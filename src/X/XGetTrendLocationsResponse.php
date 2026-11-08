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
use XTwitterScraper\TrendLocation;

/**
 * @phpstan-type XGetTrendLocationsResponseShape = array{
 *   locations: list<TrendLocation|array<string,mixed>>,
 *   count: int,
 *   total: int,
 *   message?: string|null,
 * }
 */
final class XGetTrendLocationsResponse implements BaseModel
{
    /** @use SdkModel<XGetTrendLocationsResponseShape> */
    use SdkModel;

    /**
     * @var list<TrendLocation> $locations
     */
    #[Required(list: TrendLocation::class)]
    public array $locations;

    /**
     * Locations returned & charged.
     */
    #[Required]
    public int $count;

    /**
     * Locations that match the filters, before limit.
     */
    #[Required]
    public int $total;

    /**
     * What to send instead. Present only when no location matches.
     */
    #[Optional]
    public ?string $message;

    /**
     * `new XGetTrendLocationsResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XGetTrendLocationsResponse::with(locations: ..., count: ..., total: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XGetTrendLocationsResponse)->withLocations(...)->withCount(...)->withTotal(...)
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
     * @param list<TrendLocation|array<string,mixed>> $locations
     */
    public static function with(array $locations, int $count, int $total, ?string $message = null): self
    {
        $self = new self;

        $self['locations'] = $locations;
        $self['count'] = $count;
        $self['total'] = $total;

        null !== $message && $self['message'] = $message;

        return $self;
    }

    /**
     * @param list<TrendLocation|array<string,mixed>> $locations
     */
    public function withLocations(array $locations): self
    {
        $self = clone $this;
        $self['locations'] = $locations;

        return $self;
    }

    /**
     * Locations returned & charged.
     */
    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    /**
     * Locations that match the filters, before limit.
     */
    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }

    /**
     * What to send instead. Present only when no location matches.
     */
    public function withMessage(?string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
