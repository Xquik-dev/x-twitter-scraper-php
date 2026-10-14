<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Core;

final class FileParam
{
    public const DEFAULT_CONTENT_TYPE = 'application/octet-stream';

    /**
     * @param resource|string $data
     */
    private function __construct(
        public readonly mixed $data,
        public readonly string $filename,
        public readonly string $contentType = self::DEFAULT_CONTENT_TYPE,
    ) {}

    /**
     * @param resource $resource
     */
    public static function fromResource(mixed $resource, ?string $filename = null, string $contentType = self::DEFAULT_CONTENT_TYPE): self
    {
        if (!is_resource($resource)) {
            throw new \InvalidArgumentException('Expected a resource, got '.get_debug_type($resource));
        }

        if (is_null($filename)) {
            $meta = stream_get_meta_data($resource);
            $filename = basename($meta['uri'] ?? 'upload');
        }

        return new self($resource, filename: $filename, contentType: $contentType);
    }

    public static function fromString(string $content, string $filename, string $contentType = self::DEFAULT_CONTENT_TYPE): self
    {
        return new self($content, filename: $filename, contentType: $contentType);
    }
}
