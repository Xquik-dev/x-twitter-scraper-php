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
 * @phpstan-type PaginatedUserIDsShape = array{
 *   ids: list<string>,
 *   hasNextPage: bool,
 *   nextCursor: string,
 * }
 */
final class PaginatedUserIDs implements BaseModel
{
    /** @use SdkModel<PaginatedUserIDsShape> */
    use SdkModel;

    /**
     * X user IDs, newest relationship first.
     *
     * @var list<string> $ids
     */
    #[Required(list: 'string')]
    public array $ids;

    #[Required('has_next_page')]
    public bool $hasNextPage;

    /**
     * Cursor for the next page. Send it unchanged. Each next page arrives fast.
     */
    #[Required('next_cursor')]
    public string $nextCursor;

    /**
     * `new PaginatedUserIDs()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PaginatedUserIDs::with(ids: ..., hasNextPage: ..., nextCursor: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PaginatedUserIDs)->withIds(...)->withHasNextPage(...)->withNextCursor(...)
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
     * @param list<string> $ids
     */
    public static function with(array $ids, bool $hasNextPage, string $nextCursor): self
    {
        $self = new self;

        $self['ids'] = $ids;
        $self['hasNextPage'] = $hasNextPage;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * X user IDs, newest relationship first.
     *
     * @param list<string> $ids
     */
    public function withIds(array $ids): self
    {
        $self = clone $this;
        $self['ids'] = $ids;

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
