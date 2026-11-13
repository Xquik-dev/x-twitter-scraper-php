<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use XTwitterScraper\ActivityLogRow;
use XTwitterScraper\Client;
use XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionAttemptSuccess;
use XTwitterScraper\X\Accounts\AccountNewResponse\XAccountConnectionAttemptPending;
use XTwitterScraper\X\Accounts\AccountReauthResponse;
use XTwitterScraper\X\Users\UserRetrieveMentionsParams;
use XTwitterScraper\X\Users\UserRetrieveMentionsParams\OwnThreads;

/**
 * @internal
 */
final class ApiCatchUpTest extends TestCase
{
    private const CONNECT_LINK = [
        'object' => 'x_account_connection_link',
        'id' => 'xlink_AAAAAAAAAAAAAAAA',
        'purpose' => 'connect',
        'status' => 'pending',
        'reference' => 'user-42',
        'returnUrl' => 'https://example.com/connected',
        'accountId' => null,
        'xUserId' => null,
        'xUsername' => null,
        'health' => null,
        'failure' => null,
        'createdAt' => '2025-01-15T12:00:00Z',
        'expiresAt' => '2025-01-15T12:30:00Z',
        'completedAt' => null,
    ];

    private const PENDING_ATTEMPT = '{"object":"x_account_connection_attempt","id":"xatt_0123456789abcdef0123456789abcdef","status":"pending","pollAfterMs":1000}';

    private MockClient $transporter;

    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transporter = new MockClient;
        $this->client = new Client(
            apiKey: 'My API Key',
            bearerToken: 'My Bearer Token',
            baseUrl: 'http://127.0.0.1:4010',
            requestOptions: ['transporter' => $this->transporter],
        );
    }

    #[Test]
    public function testAPathWithTwoValuesFillsBothInOrder(): void
    {
        $this->respond('application/json', '{}');

        $this->client->x->sports->retrieveRoster('nfl', 'game 1');

        $this->assertStringEndsWith('/x/sports/nfl/games/game%201/roster', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function testAListThatTookNoArgumentsSendsItsNewQuery(): void
    {
        $this->respond('application/json', '{}');

        $this->client->monitors->list(limit: 5, cursor: 'next');

        parse_str($this->lastRequest()->getUri()->getQuery(), $query);
        $this->assertSame(['limit' => '5', 'cursor' => 'next'], $query);
    }

    #[Test]
    public function testAnEmptyBulkRetrySendsNoBody(): void
    {
        $this->respond('application/json', '{}');

        $this->client->x->accounts->bulkRetry();

        $this->assertSame('', (string) $this->lastRequest()->getBody());
    }

    #[Test]
    public function testABulkRetrySendsTheAccountIDsUnderTheirAPIName(): void
    {
        $this->respond('application/json', '{}');

        $this->client->x->accounts->bulkRetry(accountIDs: ['1']);

        $this->assertSame('{"accountIds":["1"]}', (string) $this->lastRequest()->getBody());
    }

    #[Test]
    public function testANewBodyFieldTravelsBesideTheDryRunQuery(): void
    {
        $this->respond('application/json', '{}');

        $this->client->extractions->run(toolType: 'user_affiliates', dryRun: true, enrichProfiles: true);

        parse_str($this->lastRequest()->getUri()->getQuery(), $query);
        $this->assertSame(['dry_run' => 'true'], $query);
        $body = json_decode((string) $this->lastRequest()->getBody(), true);
        $this->assertIsArray($body);
        $this->assertTrue($body['enrichProfiles']);
        $this->assertArrayNotHasKey('dryRun', $body);
    }

    #[Test]
    public function testAnEventStreamAsksForServerSentEventsAndKeepsTheBodyReadable(): void
    {
        $this->respond('text/event-stream', "event: tweet.new\ndata: {}\n\n");

        $response = $this->client->events->stream();

        $this->assertSame('text/event-stream', $this->lastRequest()->getHeaderLine('Accept'));
        $this->assertStringContainsString('event: tweet.new', (string) $response->getBody());
    }

    #[Test]
    public function testANewListOperationParsesEachRow(): void
    {
        $this->respond('application/json', '[{"id":"1"}]');

        $rows = $this->client->activity->list();

        $this->assertCount(1, $rows);
        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ActivityLogRow::class, $rows[0]);
    }

    #[Test]
    public function testAConnectLinkSendsItsOptionsUnderTheirAPINames(): void
    {
        $this->respond(
            'application/json',
            json_encode(self::CONNECT_LINK + ['url' => 'https://example.com/connect#token'], JSON_THROW_ON_ERROR),
        );

        $link = $this->client->x->accountConnectionLinks->create(
            accountID: '42',
            reference: 'user-42',
            returnURL: 'https://example.com/connected',
        );

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertStringEndsWith('/x/account-connection-links', $this->lastRequest()->getUri()->getPath());
        $this->assertEquals(
            ['accountId' => '42', 'reference' => 'user-42', 'returnUrl' => 'https://example.com/connected'],
            json_decode((string) $this->lastRequest()->getBody(), true),
        );
        $this->assertSame('https://example.com/connect#token', $link->url);
    }

    #[Test]
    public function testAConnectLinkIsReadByItsID(): void
    {
        $this->respond('application/json', json_encode(self::CONNECT_LINK, JSON_THROW_ON_ERROR));

        $link = $this->client->x->accountConnectionLinks->retrieve('xlink_AAAAAAAAAAAAAAAA');

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertStringEndsWith(
            '/x/account-connection-links/xlink_AAAAAAAAAAAAAAAA',
            $this->lastRequest()->getUri()->getPath(),
        );
        $this->assertSame('user-42', $link->reference);
        $this->assertNull($link->accountID);
    }

    #[Test]
    public function testAConnectLinkIsRevokedByItsID(): void
    {
        $this->respond('application/json', '{"success":true}');

        $result = $this->client->x->accountConnectionLinks->delete('xlink_AAAAAAAAAAAAAAAA');

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertStringEndsWith(
            '/x/account-connection-links/xlink_AAAAAAAAAAAAAAAA',
            $this->lastRequest()->getUri()->getPath(),
        );
        $this->assertTrue($result->success);
    }

    #[Test]
    public function testAnAccountSendsItsConnectionAttemptID(): void
    {
        $this->respond('application/json', self::PENDING_ATTEMPT);

        $answer = $this->client->x->accounts->create(
            email: 'account@example.invalid',
            password: '<ACCOUNT_PASSWORD>',
            totpSecret: '<TOTP_SECRET>',
            username: 'your_x_username',
            connectionAttemptID: 'xatt_0123456789abcdef0123456789abcdef',
        );

        $body = json_decode((string) $this->lastRequest()->getBody(), true);
        $this->assertIsArray($body);
        $this->assertSame('xatt_0123456789abcdef0123456789abcdef', $body['connection_attempt_id']);
        $this->assertInstanceOf(XAccountConnectionAttemptPending::class, $answer);
    }

    #[Test]
    public function testAReauthStillRunningReadsAsAPendingAttempt(): void
    {
        $this->respond('application/json', self::PENDING_ATTEMPT);

        $answer = $this->client->x->accounts->reauth(
            '42',
            password: '<ACCOUNT_PASSWORD>',
            connectionAttemptID: 'xatt_0123456789abcdef0123456789abcdef',
        );

        $this->assertEquals(
            ['password' => '<ACCOUNT_PASSWORD>', 'connection_attempt_id' => 'xatt_0123456789abcdef0123456789abcdef'],
            json_decode((string) $this->lastRequest()->getBody(), true),
        );
        $this->assertInstanceOf(XAccountConnectionAttemptPending::class, $answer);
        $this->assertSame(1000, $answer->pollAfterMs);
    }

    #[Test]
    public function testAFinishedReauthStillReadsAsTheAccount(): void
    {
        $this->respond(
            'application/json',
            '{"id":"42","createdAt":"2025-01-15T12:00:00Z","health":"healthy","status":"active","xUserId":"1234567890","xUsername":"test_account"}',
        );

        $answer = $this->client->x->accounts->reauth('42', password: '<ACCOUNT_PASSWORD>');

        $this->assertInstanceOf(AccountReauthResponse::class, $answer);
        $this->assertSame('test_account', $answer->xUsername);
    }

    #[Test]
    public function testAFinishedAttemptNamesTheConnectedAccount(): void
    {
        $this->respond(
            'application/json',
            '{"object":"x_account_connection_attempt","id":"xatt_0123456789abcdef0123456789abcdef","status":"success","accountId":"42"}',
        );

        $attempt = $this->client->x->accountConnectionAttempts->retrieve('xatt_0123456789abcdef0123456789abcdef');

        $this->assertInstanceOf(XAccountConnectionAttemptSuccess::class, $attempt);
        $this->assertSame('42', $attempt->accountID);
    }

    #[Test]
    public function testAPostSendsItsMediaIDsUnderTheirAPIName(): void
    {
        $this->respond('application/json', '{}');

        $this->client->x->tweets->create(
            account: '@elonmusk',
            idempotencyKey: 'write-1',
            mediaIDs: ['2104371968258560001'],
        );

        $body = json_decode((string) $this->lastRequest()->getBody(), true);
        $this->assertIsArray($body);
        $this->assertSame(['2104371968258560001'], $body['media_ids']);
    }

    #[Test]
    public function testAMentionsReadSendsOwnThreads(): void
    {
        $this->respond('application/json', '{"tweets":[],"has_next_page":false,"next_cursor":""}');

        $this->client->x->users->retrieveMentions('44196397', replies: 'exclude', ownThreads: OwnThreads::EXCLUDE);

        parse_str($this->lastRequest()->getUri()->getQuery(), $query);
        $this->assertSame('exclude', $query['replies'] ?? null);
        $this->assertSame('exclude', $query['ownThreads'] ?? null);

        $params = UserRetrieveMentionsParams::with(ownThreads: 'exclude');
        $this->assertSame('exclude', $params->ownThreads);
        $this->assertSame('exclude', (new UserRetrieveMentionsParams)->withOwnThreads(OwnThreads::EXCLUDE)->ownThreads);
    }

    private function respond(string $contentType, string $text): void
    {
        $factory = Psr17FactoryDiscovery::findResponseFactory();
        $stream = Psr17FactoryDiscovery::findStreamFactory()->createStream($text);
        $this->transporter->addResponse(
            $factory->createResponse(200)->withHeader('Content-Type', $contentType)->withBody($stream)
        );
    }

    private function lastRequest(): RequestInterface
    {
        $requests = $this->transporter->getRequests();
        $this->assertNotEmpty($requests);

        return $requests[array_key_last($requests)];
    }
}
