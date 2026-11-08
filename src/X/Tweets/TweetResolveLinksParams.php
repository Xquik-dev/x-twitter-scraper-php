<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Returns where each t.co link leads, as X's own redirect says. Xquik reads the redirect and never visits the target site. A link t.co does not have comes back without `resolvedUrl` and costs nothing. A link X does not answer for in time comes back in `unprocessedUrls`, free. Each resolved link costs 1 credit.
 *
 * @see XTwitterScraper\Services\X\TweetsService::resolveLinks()
 *
 * @phpstan-type TweetResolveLinksParamsShape = array{
 *   urls: string,
 *   fields?: string|null,
 *   omit?: string|null,
 * }
 */
final class TweetResolveLinksParams implements BaseModel
{
    /** @use SdkModel<TweetResolveLinksParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * 1 to 100 links of the form `https://t.co/Xe1nm2pkSX`, separated by commas. Any other link is refused. A link sent twice counts once. A longer URL fails at the edge before Xquik reads it.
     */
    #[Required]
    public string $urls;

    /**
     * Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     */
    #[Optional]
    public ?string $fields;

    /**
     * Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     */
    #[Optional]
    public ?string $omit;

    /**
     * `new TweetResolveLinksParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetResolveLinksParams::with(urls: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetResolveLinksParams)->withUrls(...)
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
     */
    public static function with(string $urls, ?string $fields = null, ?string $omit = null): self
    {
        $self = new self;

        $self['urls'] = $urls;

        null !== $fields && $self['fields'] = $fields;
        null !== $omit && $self['omit'] = $omit;

        return $self;
    }

    /**
     * 1 to 100 links of the form `https://t.co/Xe1nm2pkSX`, separated by commas. Any other link is refused. A link sent twice counts once. A longer URL fails at the edge before Xquik reads it.
     */
    public function withUrls(string $urls): self
    {
        $self = clone $this;
        $self['urls'] = $urls;

        return $self;
    }

    /**
     * Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     */
    public function withFields(?string $fields): self
    {
        $self = clone $this;
        $self['fields'] = $fields;

        return $self;
    }

    /**
     * Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     */
    public function withOmit(?string $omit): self
    {
        $self = clone $this;
        $self['omit'] = $omit;

        return $self;
    }
}
