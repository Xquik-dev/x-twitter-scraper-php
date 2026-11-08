<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Communities\CommunityGetInfoResponse\Community;

/**
 * @phpstan-type CommunityPageShape = array{
 *   communities: list<Community|array<string,mixed>>,
 *   hasNextPage: bool,
 *   nextCursor: string,
 * }
 */
final class CommunityPage implements BaseModel
{
    /** @use SdkModel<CommunityPageShape> */
    use SdkModel;

    /**
     * Communities in X's order.
     *
     * @var list<Community> $communities
     */
    #[Required(list: Community::class)]
    public array $communities;

    /**
     * Whether another page of communities follows.
     */
    #[Required('has_next_page')]
    public bool $hasNextPage;

    /**
     * Cursor for the next page of communities. Empty at the end.
     */
    #[Required('next_cursor')]
    public string $nextCursor;

    /**
     * `new CommunityPage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CommunityPage::with(communities: ..., hasNextPage: ..., nextCursor: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CommunityPage)->withCommunities(...)->withHasNextPage(...)->withNextCursor(...)
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
     * @param list<Community|array<string,mixed>> $communities
     */
    public static function with(array $communities, bool $hasNextPage, string $nextCursor): self
    {
        $self = new self;

        $self['communities'] = $communities;
        $self['hasNextPage'] = $hasNextPage;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * Communities in X's order.
     *
     * @param list<Community|array<string,mixed>> $communities
     */
    public function withCommunities(array $communities): self
    {
        $self = clone $this;
        $self['communities'] = $communities;

        return $self;
    }

    /**
     * Whether another page of communities follows.
     */
    public function withHasNextPage(bool $hasNextPage): self
    {
        $self = clone $this;
        $self['hasNextPage'] = $hasNextPage;

        return $self;
    }

    /**
     * Cursor for the next page of communities. Empty at the end.
     */
    public function withNextCursor(string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }
}
