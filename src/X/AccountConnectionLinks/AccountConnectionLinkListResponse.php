<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\AccountConnectionLinks;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Your connect links, newest first.
 *
 * @phpstan-import-type XAccountConnectionLinkShape from XAccountConnectionLink
 *
 * @phpstan-type AccountConnectionLinkListResponseShape = array{
 *   hasMore: bool,
 *   links: list<XAccountConnectionLink|XAccountConnectionLinkShape>,
 *   nextCursor?: string|null,
 * }
 */
final class AccountConnectionLinkListResponse implements BaseModel
{
    /** @use SdkModel<AccountConnectionLinkListResponseShape> */
    use SdkModel;

    #[Required]
    public bool $hasMore;

    /** @var list<XAccountConnectionLink> $links */
    #[Required(list: XAccountConnectionLink::class)]
    public array $links;

    #[Optional]
    public ?string $nextCursor;

    /**
     * `new AccountConnectionLinkListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AccountConnectionLinkListResponse::with(hasMore: ..., links: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AccountConnectionLinkListResponse)->withHasMore(...)->withLinks(...)
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
     * @param list<XAccountConnectionLink|XAccountConnectionLinkShape> $links
     */
    public static function with(bool $hasMore, array $links, ?string $nextCursor = null): self
    {
        $self = new self;

        $self['hasMore'] = $hasMore;
        $self['links'] = $links;

        null !== $nextCursor && $self['nextCursor'] = $nextCursor;

        return $self;
    }

    public function withHasMore(bool $hasMore): self
    {
        $self = clone $this;
        $self['hasMore'] = $hasMore;

        return $self;
    }

    /**
     * @param list<XAccountConnectionLink|XAccountConnectionLinkShape> $links
     */
    public function withLinks(array $links): self
    {
        $self = clone $this;
        $self['links'] = $links;

        return $self;
    }

    public function withNextCursor(?string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }
}
