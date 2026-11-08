<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\ResolvedLink;

/**
 * @phpstan-type TweetResolveLinksResponseShape = array{
 *   links: list<ResolvedLink|array<string,mixed>>,
 *   unprocessedUrls: list<string>,
 * }
 */
final class TweetResolveLinksResponse implements BaseModel
{
    /** @use SdkModel<TweetResolveLinksResponseShape> */
    use SdkModel;

    /**
     * @var list<ResolvedLink> $links
     */
    #[Required(list: ResolvedLink::class)]
    public array $links;

    /**
     * Links not read, in the order sent. X did not answer for them in time, or available credits ran out. Send them again.
     *
     * @var list<string> $unprocessedUrls
     */
    #[Required(list: 'string')]
    public array $unprocessedUrls;

    /**
     * `new TweetResolveLinksResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetResolveLinksResponse::with(links: ..., unprocessedUrls: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetResolveLinksResponse)->withLinks(...)->withUnprocessedUrls(...)
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
     * @param list<ResolvedLink|array<string,mixed>> $links
     * @param list<string> $unprocessedUrls
     */
    public static function with(array $links, array $unprocessedUrls): self
    {
        $self = new self;

        $self['links'] = $links;
        $self['unprocessedUrls'] = $unprocessedUrls;

        return $self;
    }

    /**
     * @param list<ResolvedLink|array<string,mixed>> $links
     */
    public function withLinks(array $links): self
    {
        $self = clone $this;
        $self['links'] = $links;

        return $self;
    }

    /**
     * Links not read, in the order sent. X did not answer for them in time, or available credits ran out. Send them again.
     *
     * @param list<string> $unprocessedUrls
     */
    public function withUnprocessedUrls(array $unprocessedUrls): self
    {
        $self = clone $this;
        $self['unprocessedUrls'] = $unprocessedUrls;

        return $self;
    }
}
