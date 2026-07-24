<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Extractions;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get extraction results.
 *
 * @see XTwitterScraper\Services\ExtractionsService::retrieve()
 *
 * @phpstan-type ExtractionRetrieveParamsShape = array{
 *   cursor?: string|null, limit?: int|null
 * }
 */
final class ExtractionRetrieveParams implements BaseModel
{
    /** @use SdkModel<ExtractionRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Cursor for keyset pagination from prior response next_cursor.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Maximum number of results to return (1-1000, default 100).
     */
    #[Optional]
    public ?int $limit;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $cursor = null, ?int $limit = null): self
    {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $limit && $self['limit'] = $limit;

        return $self;
    }

    /**
     * Cursor for keyset pagination from prior response next_cursor.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Maximum number of results to return (1-1000, default 100).
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }
}
