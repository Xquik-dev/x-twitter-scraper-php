<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Support\RequestSignatures;

use const XTwitterScraper\VERSION;

/**
 * @internal
 *
 * @phpstan-import-type Parameter from RequestSignatures
 * @phpstan-import-type Signatures from RequestSignatures
 */
final class RequestSignaturesTest extends TestCase
{
    private const RECORD = __DIR__.'/request-signatures.txt';

    private const SOURCE = __DIR__.'/../src';

    #[Test]
    public function testEveryCallThatRanOnTheRecordedReleaseBindsTheSameArguments(): void
    {
        $released = RequestSignatures::parse($this->record());

        $this->assertSame([], RequestSignatures::breaks($released, RequestSignatures::read(self::SOURCE)));
    }

    #[Test]
    public function testTheRecordNamesTheCurrentVersion(): void
    {
        $this->assertSame(
            VERSION,
            RequestSignatures::parse($this->record())['version'],
            RequestSignatures::FILE.' must record the current release. In the version bump, run php scripts/record-request-signatures.php.',
        );
    }

    #[Test]
    public function testTheRecordReadsBackAsWritten(): void
    {
        $record = $this->record();

        $this->assertSame($record, RequestSignatures::render(RequestSignatures::parse($record)));
    }

    /**
     * @param Signatures $current
     * @param list<string> $breaks
     */
    #[Test]
    #[DataProvider('changes')]
    public function testEachChangeToAReleasedMethodBreaksOnlyWhenOldCallsWouldBindDifferently(array $current, array $breaks): void
    {
        $released = ['version' => '1.0.0', 'signatures' => ['Service::call' => [self::text('id'), self::options()]]];

        $this->assertSame($breaks, RequestSignatures::breaks($released, $current));
    }

    /**
     * @return array<string, array{Signatures, list<string>}>
     */
    public static function changes(): array
    {
        return [
            'unchanged' => [['Service::call' => [self::text('id'), self::options()]], []],
            'a parameter added last' => [['Service::call' => [self::text('id'), self::options(), self::text('fields', optional: true)]], []],
            'a parameter added in front' => [
                ['Service::call' => [self::text('fields', optional: true), self::text('id'), self::options()]],
                ['Service::call argument 1 is $id in 1.0.0, but $fields now.'],
            ],
            'a parameter added before requestOptions' => [
                ['Service::call' => [self::text('id'), self::text('fields', optional: true), self::options()]],
                ['Service::call argument 2 is $requestOptions in 1.0.0, but $fields now.'],
            ],
            'a parameter renamed' => [
                ['Service::call' => [self::text('tweetID'), self::options()]],
                ['Service::call argument 1 is $id in 1.0.0, but $tweetID now.'],
            ],
            'a parameter removed' => [
                ['Service::call' => [self::text('id')]],
                ['Service::call argument 2 is $requestOptions in 1.0.0, but nothing now.'],
            ],
            'a type widened' => [['Service::call' => [['name' => 'id', 'type' => 'string|int', 'optional' => false, 'variadic' => false], self::options()]], []],
            'a type narrowed' => [
                ['Service::call' => [self::text('id'), ['name' => 'requestOptions', 'type' => 'RequestOptions|null', 'optional' => true, 'variadic' => false]]],
                ['Service::call argument 2 $requestOptions took RequestOptions|array|null in 1.0.0, but takes RequestOptions|null now.'],
            ],
            'an untyped parameter' => [['Service::call' => [['name' => 'id', 'type' => '', 'optional' => false, 'variadic' => false], self::options()]], []],
            'an optional parameter made required' => [
                ['Service::call' => [self::text('id'), ['name' => 'requestOptions', 'type' => 'RequestOptions|array|null', 'optional' => false, 'variadic' => false]]],
                ['Service::call argument 2 $requestOptions was optional in 1.0.0, but is required now.'],
            ],
            'a required parameter added last' => [
                ['Service::call' => [self::text('id'), self::options(), self::text('fields')]],
                ['Service::call adds the required $fields, which 1.0.0 calls leave out.'],
            ],
            'the method removed' => [[], ['Service::call is gone, but 1.0.0 callers still call it.']],
            'a new method' => [['Service::call' => [self::text('id'), self::options()], 'Service::list' => [self::text('cursor')]], []],
        ];
    }

    #[Test]
    public function testTheNextRecordRefusesTheSameVersion(): void
    {
        $this->expectExceptionMessage(RequestSignatures::FILE.' already records 1.0.0. Run this after the version bump.');

        RequestSignatures::next("release 1.0.0\nService::call(string \$id)\n", '1.0.0', ['Service::call' => [self::text('id')]]);
    }

    #[Test]
    public function testTheNextRecordRefusesABreak(): void
    {
        $this->expectExceptionMessage('Service::call argument 1 is $id in 1.0.0, but $fields now.');

        RequestSignatures::next(
            "release 1.0.0\nService::call(string \$id)\n",
            '1.1.0',
            ['Service::call' => [self::text('fields', optional: true), self::text('id')]],
        );
    }

    #[Test]
    public function testTheNextRecordHoldsTheNewVersionAndEveryCurrentMethod(): void
    {
        $next = RequestSignatures::next(
            "release 1.0.0\nService::call(string \$id)\n",
            '1.1.0',
            ['Service::call' => [self::text('id'), self::text('fields', optional: true)], 'Service::list' => [['name' => 'ids', 'type' => 'string', 'optional' => true, 'variadic' => true]]],
        );

        $this->assertSame("release 1.1.0\nService::call(string \$id, ?string \$fields = ...)\nService::list(string ...\$ids)\n", $next);
    }

    #[Test]
    public function testARecordWithoutItsHeaderIsRefused(): void
    {
        $this->expectExceptionMessage(RequestSignatures::FILE.' must start with the line release <version>.');

        RequestSignatures::parse("Service::call(string \$id)\n");
    }

    #[Test]
    public function testARecordLineItCannotReadIsRefused(): void
    {
        $this->expectExceptionMessage(RequestSignatures::FILE.' has a line it cannot read: Service::call(string id)');

        RequestSignatures::parse("release 1.0.0\nService::call(string id)\n");
    }

    #[Test]
    public function testAMissingSourceIsRefused(): void
    {
        $this->expectExceptionMessage('/nowhere does not exist.');

        RequestSignatures::read(self::SOURCE.'/nowhere');
    }

    private function record(): string
    {
        $record = file_get_contents(self::RECORD);
        $this->assertIsString($record);

        return $record;
    }

    /**
     * @return Parameter
     */
    private static function text(string $name, bool $optional = false): array
    {
        return ['name' => $name, 'type' => $optional ? '?string' : 'string', 'optional' => $optional, 'variadic' => false];
    }

    /**
     * @return Parameter
     */
    private static function options(): array
    {
        return ['name' => 'requestOptions', 'type' => 'RequestOptions|array|null', 'optional' => true, 'variadic' => false];
    }
}
