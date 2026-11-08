<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Monitors\Keywords;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @see XTwitterScraper\Services\Monitors\KeywordsService::list()
 *
 * @phpstan-type KeywordListParamsShape = array{
 *   limit?: int|null,
 *   cursor?: string|null,
 * }
 */
final class KeywordListParams implements BaseModel
{
    /** @use SdkModel<KeywordListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Maximum items per page, from 1 to 10,000. Default 200. Pass nextCursor as cursor for the next page.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Previous nextCursor. The after alias also works. Offset pagination is not supported.
     */
    #[Optional]
    public ?string $cursor;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $limit = null, ?string $cursor = null): self
    {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $cursor && $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Maximum items per page, from 1 to 10,000. Default 200. Pass nextCursor as cursor for the next page.
     */
    public function withLimit(?int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Previous nextCursor. The after alias also works. Offset pagination is not supported.
     */
    public function withCursor(?string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }
}
