<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace Tests\Core;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Core\FileParam;

/**
 * @internal
 */
final class FileParamTest extends TestCase
{
    #[Test]
    public function testStringAndResourceFactoriesPreserveMetadata(): void
    {
        $string = FileParam::fromString('content', 'tweets.csv', 'text/csv');
        $this->assertSame('content', $string->data);
        $this->assertSame('tweets.csv', $string->filename);
        $this->assertSame('text/csv', $string->contentType);

        $resource = fopen('php://temp', 'w+');
        $this->assertIsResource($resource);
        $explicit = FileParam::fromResource($resource, 'followers.json');
        $this->assertSame($resource, $explicit->data);
        $this->assertSame('followers.json', $explicit->filename);
        $this->assertSame(FileParam::DEFAULT_CONTENT_TYPE, $explicit->contentType);

        $derived = FileParam::fromResource($resource);
        $this->assertSame('temp', $derived->filename);
        fclose($resource);
    }

    #[Test]
    public function testResourceFactoryRejectsNonResources(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a resource, got string');
        $method = new \ReflectionMethod(FileParam::class, 'fromResource');
        $method->invoke(null, 'not-a-resource');
    }
}
