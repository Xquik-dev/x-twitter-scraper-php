<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\PlaceSearchResult;

/**
 * @phpstan-type XSearchPlacesResponseShape = array{
 *   places: list<PlaceSearchResult|array<string,mixed>>,
 *   count: int,
 *   total: int,
 *   message?: string|null,
 * }
 */
final class XSearchPlacesResponse implements BaseModel
{
    /** @use SdkModel<XSearchPlacesResponseShape> */
    use SdkModel;

    /**
     * @var list<PlaceSearchResult> $places
     */
    #[Required(list: PlaceSearchResult::class)]
    public array $places;

    /**
     * Places returned & charged.
     */
    #[Required]
    public int $count;

    /**
     * Places X found, before limit.
     */
    #[Required]
    public int $total;

    /**
     * What to send instead. Present only when X finds no place.
     */
    #[Optional]
    public ?string $message;

    /**
     * `new XSearchPlacesResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XSearchPlacesResponse::with(places: ..., count: ..., total: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XSearchPlacesResponse)->withPlaces(...)->withCount(...)->withTotal(...)
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
     * @param list<PlaceSearchResult|array<string,mixed>> $places
     */
    public static function with(array $places, int $count, int $total, ?string $message = null): self
    {
        $self = new self;

        $self['places'] = $places;
        $self['count'] = $count;
        $self['total'] = $total;

        null !== $message && $self['message'] = $message;

        return $self;
    }

    /**
     * @param list<PlaceSearchResult|array<string,mixed>> $places
     */
    public function withPlaces(array $places): self
    {
        $self = clone $this;
        $self['places'] = $places;

        return $self;
    }

    /**
     * Places returned & charged.
     */
    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    /**
     * Places X found, before limit.
     */
    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }

    /**
     * What to send instead. Present only when X finds no place.
     */
    public function withMessage(?string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
