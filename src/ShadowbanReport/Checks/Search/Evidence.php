<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks\Search;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type EvidenceShape = array{
 *   query: string,
 *   searchUrl: string,
 *   recentPostIDs: list<string>,
 *   foundPostIDs: list<string>,
 * }
 */
final class Evidence implements BaseModel
{
    /** @use SdkModel<EvidenceShape> */
    use SdkModel;

    /**
     * The search it ran.
     */
    #[Required]
    public string $query;

    /**
     * The same search on X, sorted by Latest.
     */
    #[Required]
    public string $searchUrl;

    /**
     * Up to 5 recent posts of the account.
     *
     * @var list<string> $recentPostIDs
     */
    #[Required('recentPostIds', list: 'string')]
    public array $recentPostIDs;

    /**
     * Up to 5 posts of the account that search showed.
     *
     * @var list<string> $foundPostIDs
     */
    #[Required('foundPostIds', list: 'string')]
    public array $foundPostIDs;

    /**
     * `new Evidence()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Evidence::with(query: ..., searchUrl: ..., recentPostIDs: ..., foundPostIDs: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Evidence)->withQuery(...)->withSearchUrl(...)->withRecentPostIDs(...)->withFoundPostIDs(...)
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
     * @param list<string> $recentPostIDs
     * @param list<string> $foundPostIDs
     */
    public static function with(string $query, string $searchUrl, array $recentPostIDs, array $foundPostIDs): self
    {
        $self = new self;

        $self['query'] = $query;
        $self['searchUrl'] = $searchUrl;
        $self['recentPostIDs'] = $recentPostIDs;
        $self['foundPostIDs'] = $foundPostIDs;

        return $self;
    }

    /**
     * The search it ran.
     */
    public function withQuery(string $query): self
    {
        $self = clone $this;
        $self['query'] = $query;

        return $self;
    }

    /**
     * The same search on X, sorted by Latest.
     */
    public function withSearchUrl(string $searchUrl): self
    {
        $self = clone $this;
        $self['searchUrl'] = $searchUrl;

        return $self;
    }

    /**
     * Up to 5 recent posts of the account.
     *
     * @param list<string> $recentPostIDs
     */
    public function withRecentPostIDs(array $recentPostIDs): self
    {
        $self = clone $this;
        $self['recentPostIDs'] = $recentPostIDs;

        return $self;
    }

    /**
     * Up to 5 posts of the account that search showed.
     *
     * @param list<string> $foundPostIDs
     */
    public function withFoundPostIDs(array $foundPostIDs): self
    {
        $self = clone $this;
        $self['foundPostIDs'] = $foundPostIDs;

        return $self;
    }
}
