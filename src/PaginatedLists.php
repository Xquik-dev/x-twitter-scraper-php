<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type PaginatedListsShape = array{
 *   lists: list<XList|array<string,mixed>>,
 *   hasNextPage: bool,
 *   nextCursor: string,
 * }
 */
final class PaginatedLists implements BaseModel
{
    /** @use SdkModel<PaginatedListsShape> */
    use SdkModel;

    /**
     * @var list<XList> $lists
     */
    #[Required(list: XList::class)]
    public array $lists;

    #[Required('has_next_page')]
    public bool $hasNextPage;

    /**
     * Cursor for the next page. Send it unchanged. Each next page arrives fast.
     */
    #[Required('next_cursor')]
    public string $nextCursor;

    /**
     * `new PaginatedLists()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PaginatedLists::with(lists: ..., hasNextPage: ..., nextCursor: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PaginatedLists)->withLists(...)->withHasNextPage(...)->withNextCursor(...)
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
     * @param list<XList|array<string,mixed>> $lists
     */
    public static function with(array $lists, bool $hasNextPage, string $nextCursor): self
    {
        $self = new self;

        $self['lists'] = $lists;
        $self['hasNextPage'] = $hasNextPage;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * @param list<XList|array<string,mixed>> $lists
     */
    public function withLists(array $lists): self
    {
        $self = clone $this;
        $self['lists'] = $lists;

        return $self;
    }

    public function withHasNextPage(bool $hasNextPage): self
    {
        $self = clone $this;
        $self['hasNextPage'] = $hasNextPage;

        return $self;
    }

    /**
     * Cursor for the next page. Send it unchanged. Each next page arrives fast.
     */
    public function withNextCursor(string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }
}
