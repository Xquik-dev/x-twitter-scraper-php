<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Spaces;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Space;

/**
 * @phpstan-type SpaceSearchResponseShape = array{
 *   spaces: list<Space|array<string,mixed>>,
 *   hasNextPage: bool,
 *   nextCursor: string,
 * }
 */
final class SpaceSearchResponse implements BaseModel
{
    /** @use SdkModel<SpaceSearchResponseShape> */
    use SdkModel;

    /**
     * Public Spaces, each once. Latest & Top list them in the order the posts share them. Live & Upcoming keep X's order.
     *
     * @var list<Space> $spaces
     */
    #[Required(list: Space::class)]
    public array $spaces;

    #[Required('has_next_page')]
    public bool $hasNextPage;

    /**
     * Cursor for the next page. Send it unchanged. Each next page arrives fast.
     */
    #[Required('next_cursor')]
    public string $nextCursor;

    /**
     * `new SpaceSearchResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SpaceSearchResponse::with(spaces: ..., hasNextPage: ..., nextCursor: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SpaceSearchResponse)->withSpaces(...)->withHasNextPage(...)->withNextCursor(...)
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
     * @param list<Space|array<string,mixed>> $spaces
     */
    public static function with(array $spaces, bool $hasNextPage, string $nextCursor): self
    {
        $self = new self;

        $self['spaces'] = $spaces;
        $self['hasNextPage'] = $hasNextPage;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * Public Spaces, each once. Latest & Top list them in the order the posts share them. Live & Upcoming keep X's order.
     *
     * @param list<Space|array<string,mixed>> $spaces
     */
    public function withSpaces(array $spaces): self
    {
        $self = clone $this;
        $self['spaces'] = $spaces;

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
