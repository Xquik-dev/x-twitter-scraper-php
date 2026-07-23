<?php

namespace Tests\Core;

use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use XTwitterScraper\Core\FileParam;
use XTwitterScraper\Core\Util;

/**
 * @internal
 */
#[RunTestsInSeparateProcesses]
class UtilTest extends TestCase
{
    #[Test]
    public function testEnvironmentAndPlatformHelpers(): void
    {
        $key = 'XQUIK_PHP_SDK_TEST_ENV';
        $previousEnvironment = $_ENV[$key] ?? null;
        $hadEnvironment = array_key_exists($key, $_ENV);
        $previousProcess = getenv($key);

        try {
            $_ENV[$key] = 'environment-value';
            putenv("{$key}=process-value");
            $this->assertSame('environment-value', Util::getenv($key));

            unset($_ENV[$key]);
            $this->assertSame('process-value', Util::getenv($key));

            putenv($key);
            $this->assertNull(Util::getenv($key));

            $_ENV[$key] = ['invalid'];

            try {
                Util::getenv($key);
                $this->fail('Expected invalid environment value to fail.');
            } catch (\InvalidArgumentException) {
                $this->addToAssertionCount(1);
            }
        } finally {
            if ($hadEnvironment) {
                $_ENV[$key] = $previousEnvironment;
            } else {
                unset($_ENV[$key]);
            }

            if (false === $previousProcess) {
                putenv($key);
            } else {
                putenv("{$key}={$previousProcess}");
            }
        }

        $this->assertContains(Util::machtype(), ['arm64', 'x64', 'x32', 'arm', 'unknown']);
        $this->assertContains(Util::ostype(), ['Linux', 'MacOS', 'Windows', 'Solaris', 'BSD']);
        $this->assertSame(['visible' => 1], Util::get_object_vars((object) ['visible' => 1]));
    }

    #[Test]
    public function testValueAndPathHelpers(): void
    {
        $date = new \DateTimeImmutable('2026-01-02T03:04:05+00:00');

        $this->assertSame(['renamed' => 1, 'kept' => 2], Util::array_transform_keys(
            ['original' => 1, 'kept' => 2],
            ['original' => 'renamed'],
        ));
        $this->assertSame('true', Util::strVal(true));
        $this->assertSame('false', Util::strVal(false));
        $this->assertSame('42', Util::strVal(42));
        $this->assertSame('2026-01-02T03:04:05+00:00', Util::strVal($date));
        $this->assertSame(['nested' => ['kept' => 1], 'list' => [null]], Util::removeNulls([
            'discarded' => null,
            'nested' => ['discarded' => null, 'kept' => 1],
            'list' => [null],
        ]));
        $this->assertSame(2, Util::dig(['a' => ['b' => 2]], ['a', 'b']));
        $this->assertSame(['b' => 2], Util::dig(['a' => ['b' => 2]], 'a'));
        $this->assertSame('called', Util::dig('value', static fn (string $value): string => 'called'));
        $this->assertNull(Util::dig(['a' => 1], ['missing']));
        $this->assertNull(Util::dig('not-an-array', 'a'));
        $this->assertSame('', Util::parsePath([]));
        $this->assertSame('/users/alice%20smith/7', Util::parsePath(['/users/%s/%s', 'alice smith', 7]));
        $this->assertSame('/literal', Util::parsePath('/literal'));
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Path templates must be strings');
        Util::parsePath([1]);
    }

    #[Test]
    public function testMergeBodyHonorsDocumentedOverrides(): void
    {
        $this->assertSame(['base' => 1], Util::mergeBody(['base' => 1], null));
        $this->assertSame(['base' => 1], Util::mergeBody(['base' => 1], []));
        $this->assertSame(['base' => 1], Util::mergeBody(['base' => 1], ['list']));
        $this->assertSame(['base' => 1], Util::mergeBody(['base' => 1], 'invalid'));
        $this->assertSame(['extra' => 2], Util::mergeBody(null, ['extra' => 2]));
        $this->assertSame(
            ['base' => 1, 'shared' => 'extra', 'extra' => 2],
            Util::mergeBody(['base' => 1, 'shared' => 'base'], ['shared' => 'extra', 'extra' => 2]),
        );
        $this->assertSame(
            ['base' => 1, 'extra' => 2],
            Util::mergeBody((object) ['base' => 1], (object) ['extra' => 2]),
        );
        $this->assertSame(['list'], Util::mergeBody(['list'], ['extra' => 2]));
        $this->assertSame('scalar', Util::mergeBody('scalar', ['extra' => 2]));
    }

    #[Test]
    public function testOneShotBodiesDisableRetriesWithoutConsumingInput(): void
    {
        $this->assertTrue(Util::bodyCanRetry(null));
        $this->assertTrue(Util::bodyCanRetry(['nested' => (object) ['value' => 'safe']]));
        $this->assertTrue(Util::bodyCanRetry(FileParam::fromString('content', 'file.txt')));

        $resource = fopen('php://temp', 'w+');
        $this->assertIsResource($resource);
        $this->assertFalse(Util::bodyCanRetry($resource));
        $this->assertFalse(Util::bodyCanRetry(['file' => FileParam::fromResource($resource, 'file.txt')]));
        $this->assertFalse(Util::bodyCanRetry((object) ['nested' => ['stream' => $resource]]));

        $generator = (static function (): \Generator {
            yield 'one-shot';
        })();
        $this->assertFalse(Util::bodyCanRetry($generator));
        $this->assertTrue($generator->valid());
        fclose($resource);
    }

    #[Test]
    public function testMapRecursive(): void
    {
        $cases = [
            [
                [],
                [],
                static fn ($v) => $v,
            ],
            [
                ['a' => null, 'b' => [null, null], 'c' => ['d' => null, 'e' => 0], 'f' => ['g' => null]],
                ['b' => [null, null], 'c' => ['e' => 0], 'f' => []],
                static fn ($vs) => is_array($vs) && !array_is_list($vs) ? array_filter($vs, callback: static fn ($v) => !is_null($v)) : $vs,
            ],
            [
                ['a' => null, 'b' => 2, 'c' => true, 'd' => [1, 2]],
                ['a' => null, 'b' => '2', 'c' => true, 'd' => ['1', '2']],
                static fn ($v) => is_bool($v) || is_numeric($v) ? Util::strVal($v) : $v,
            ],
        ];

        foreach ($cases as [$input, $expected, $xform]) {
            $actual = Util::mapRecursive($xform, value: $input);
            $this->assertEquals($expected, $actual);
        }
    }

    #[Test]
    public function testJoinUri(): void
    {
        $factory = Psr17FactoryDiscovery::findUriFactory();
        $base = $factory->createUri('http://localhost');
        $cases = [
            [
                '',
                [],
                'http://localhost',
            ],
            [
                'dog',
                [],
                'http://localhost/dog',
            ],
            [
                '',
                ['dog' => 'dog'],
                'http://localhost?dog=dog',
            ],
            [
                '',
                ['dog' => ['dog']],
                'http://localhost?dog[0]=dog',
            ],
            [
                '',
                ['dog' => [true, false]],
                'http://localhost?dog[0]=true&dog[1]=false',
            ],
            [
                '',
                ['dog' => ['dog' => ['dog']]],
                'http://localhost?dog[dog][0]=dog',
            ],
        ];

        foreach ($cases as [$path, $query, $output]) {
            $expected = $factory->createUri($output);
            $actual = Util::joinUri($base, path: $path, query: $query);
            $this->assertEquals($expected, $actual);
        }

        $base = $factory->createUri('https://old.example/base?one=1');
        $actual = Util::joinUri(
            $base,
            'http://user:pass@new.example:8080/path?two=2',
            ['flag' => true],
        );
        $this->assertSame(
            'http://user:pass@new.example:8080/path?one=1&two=2&flag=true',
            (string) $actual,
        );
    }

    #[Test]
    public function testHeadersStreamsAndBodies(): void
    {
        $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $request = $requestFactory
            ->createRequest('POST', 'https://example.test')
            ->withHeader('Remove', 'value')
        ;
        $request = Util::withSetHeaders($request, [
            'Remove' => null,
            'Numbers' => [1, 2],
            'Enabled' => 1,
        ]);
        $this->assertFalse($request->hasHeader('Remove'));
        $this->assertSame(['1', '2'], $request->getHeader('Numbers'));
        $this->assertSame('1', $request->getHeaderLine('Enabled'));

        $stream = $streamFactory->createStream('stream-body');
        $streamRequest = Util::withSetBody($streamFactory, $request, $stream);
        $this->assertSame($stream, $streamRequest->getBody());

        $jsonRequest = Util::withSetBody(
            $streamFactory,
            $request->withHeader('Content-Type', 'application/json'),
            ['name' => 'Xquik'],
        );
        $this->assertSame('{"name":"Xquik"}', (string) $jsonRequest->getBody());

        $resource = fopen('php://temp', 'w+');
        $this->assertIsResource($resource);
        fwrite($resource, 'resource-body');
        rewind($resource);
        $resourceRequest = Util::withSetBody($streamFactory, $request, $resource);
        $this->assertSame('resource-body', (string) $resourceRequest->getBody());
        fclose($resource);

        $stringRequest = Util::withSetBody($streamFactory, $request, 'string-body');
        $this->assertSame('string-body', (string) $stringRequest->getBody());
        $this->assertSame('', (string) Util::withSetBody($streamFactory, $request, 42)->getBody());

        $multipartResource = fopen('php://temp', 'w+');
        $this->assertIsResource($multipartResource);
        fwrite($multipartResource, 'resource-file');
        rewind($multipartResource);
        $multipart = Util::withSetBody(
            $streamFactory,
            $request->withHeader('Content-Type', 'multipart/form-data'),
            [
                "unsafe\r\nname\"" => ['one', 2],
                'boolean' => true,
                'object' => (object) ['key' => 'value'],
                'file' => FileParam::fromString('file-body', "unsafe\r\nfile\".txt", 'text/plain'),
                'resource' => FileParam::fromResource($multipartResource, 'resource.txt'),
            ],
        );
        $contentType = $multipart->getHeaderLine('Content-Type');
        $body = (string) $multipart->getBody();
        $this->assertMatchesRegularExpression('/^multipart\/form-data; boundary=/', $contentType);
        $this->assertStringContainsString('name="unsafename"', $body);
        $this->assertStringContainsString('filename="unsafefile.txt"', $body);
        $this->assertStringContainsString('file-body', $body);
        $this->assertStringContainsString('resource-file', $body);
        $this->assertStringContainsString('{"key":"value"}', $body);
        $this->assertSame(2, substr_count($body, 'name="unsafename"'));
        fclose($multipartResource);

        $scalarMultipart = Util::withSetBody(
            $streamFactory,
            $request->withHeader('Content-Type', 'multipart/form-data'),
            null,
        );
        $this->assertStringContainsString('application/json', (string) $scalarMultipart->getBody());
    }

    #[Test]
    public function testStreamIteratorClosesReadableStreamAndIgnoresUnreadableStream(): void
    {
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $readable = $streamFactory->createStream(str_repeat('a', Util::BUF_SIZE + 1));
        $chunks = iterator_to_array(Util::streamIterator($readable), preserve_keys: false);
        $this->assertSame([str_repeat('a', Util::BUF_SIZE), 'a'], $chunks);
        $this->assertFalse($readable->isReadable());

        $unreadable = $this->createStub(StreamInterface::class);
        $unreadable->method('isReadable')->willReturn(false);
        $this->assertSame([], iterator_to_array(Util::streamIterator($unreadable), preserve_keys: false));
    }

    #[Test]
    public function testLineSseAndContentDecoders(): void
    {
        $lines = Util::decodeLines(new \ArrayIterator(["one\nt", "wo\nthree"]));
        $this->assertSame(['one', 'two', 'three'], iterator_to_array($lines, preserve_keys: false));

        $events = Util::decodeSSE(new \ArrayIterator([
            ': comment',
            '',
            'event: update',
            'data: first',
            'data: second',
            'id: 7',
            'retry: 250',
            'unknown: ignored',
            '',
            'data: tail',
        ]));
        $this->assertSame([
            ['event' => 'update', 'data' => "first\nsecond", 'id' => '7', 'retry' => 250],
            ['event' => null, 'data' => 'tail', 'id' => null, 'retry' => null],
        ], iterator_to_array($events, preserve_keys: false));

        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $this->assertNull(Util::decodeContent($responseFactory->createResponse(204)));

        $json = $responseFactory->createResponse()
            ->withHeader('Content-Type', 'application/vnd.xquik+json')
            ->withBody($streamFactory->createStream('{"ok":true}'))
        ;
        $this->assertSame(['ok' => true], Util::decodeContent($json));

        $jsonl = $responseFactory->createResponse()
            ->withHeader('Content-Type', 'application/x-ndjson')
            ->withBody($streamFactory->createStream("{\"id\":1}\n{\"id\":2}"))
        ;
        $decodedJsonl = Util::decodeContent($jsonl);
        $this->assertInstanceOf(\Traversable::class, $decodedJsonl);
        $this->assertSame(
            [['id' => 1], ['id' => 2]],
            iterator_to_array($decodedJsonl, preserve_keys: false),
        );

        $sse = $responseFactory->createResponse()
            ->withHeader('Content-Type', 'text/event-stream')
            ->withBody($streamFactory->createStream("data: value\n\n"))
        ;
        $decodedSse = Util::decodeContent($sse);
        $this->assertInstanceOf(\Traversable::class, $decodedSse);
        $this->assertSame(
            [['event' => null, 'data' => 'value', 'id' => null, 'retry' => null]],
            iterator_to_array($decodedSse, preserve_keys: false),
        );

        $text = $responseFactory->createResponse()
            ->withHeader('Content-Type', 'text/plain')
            ->withBody($streamFactory->createStream('plain'))
        ;
        $decodedText = Util::decodeContent($text);
        $this->assertInstanceOf(\Traversable::class, $decodedText);
        $this->assertSame(['plain'], iterator_to_array($decodedText, preserve_keys: false));
        $this->assertSame(['decoded' => true], Util::decodeJson('{"decoded":true}'));
        $this->assertSame("{\n    \"pretty\": true\n}", Util::prettyEncodeJson(['pretty' => true]));

        $invalid = fopen('php://temp', 'w+');
        $this->assertIsResource($invalid);
        $this->assertSame('', Util::prettyEncodeJson($invalid));
        fclose($invalid);
    }
}
