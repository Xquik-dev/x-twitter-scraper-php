<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\PaginatedTweets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\PaginatedTweets\SearchContext\SmartTag;

/**
 * @phpstan-type SearchContextShape = array{
 *   smartTag: SmartTag|array<string,mixed>,
 * }
 */
final class SearchContext implements BaseModel
{
    /** @use SdkModel<SearchContextShape> */
    use SdkModel;

    /**
     * X's card for the cashtag the search names.
     */
    #[Required]
    public SmartTag $smartTag;

    /**
     * `new SearchContext()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SearchContext::with(smartTag: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SearchContext)->withSmartTag(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param SmartTag|array<string,mixed> $smartTag
     */
    public static function with(SmartTag|array $smartTag): self
    {
        $self = new self;

        $self['smartTag'] = $smartTag;

        return $self;
    }

    /**
     * X's card for the cashtag the search names.
     *
     * @param SmartTag|array<string,mixed> $smartTag
     */
    public function withSmartTag(SmartTag|array $smartTag): self
    {
        $self = clone $this;
        $self['smartTag'] = $smartTag;

        return $self;
    }
}
