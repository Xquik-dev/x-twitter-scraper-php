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
 * @phpstan-type PaginatedCommunityNotesShape = array{
 *   notes: list<CommunityNote|array<string,mixed>>,
 *   hasNextPage: bool,
 *   nextCursor: string,
 * }
 */
final class PaginatedCommunityNotes implements BaseModel
{
    /** @use SdkModel<PaginatedCommunityNotesShape> */
    use SdkModel;

    /**
     * @var list<CommunityNote> $notes
     */
    #[Required(list: CommunityNote::class)]
    public array $notes;

    #[Required('has_next_page')]
    public bool $hasNextPage;

    /**
     * Cursor for the next page. Send it unchanged. Each next page arrives fast.
     */
    #[Required('next_cursor')]
    public string $nextCursor;

    /**
     * `new PaginatedCommunityNotes()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PaginatedCommunityNotes::with(notes: ..., hasNextPage: ..., nextCursor: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PaginatedCommunityNotes)->withNotes(...)->withHasNextPage(...)->withNextCursor(...)
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
     * @param list<CommunityNote|array<string,mixed>> $notes
     */
    public static function with(array $notes, bool $hasNextPage, string $nextCursor): self
    {
        $self = new self;

        $self['notes'] = $notes;
        $self['hasNextPage'] = $hasNextPage;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * @param list<CommunityNote|array<string,mixed>> $notes
     */
    public function withNotes(array $notes): self
    {
        $self = clone $this;
        $self['notes'] = $notes;

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
