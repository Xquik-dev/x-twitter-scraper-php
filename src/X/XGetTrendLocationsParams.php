<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\XGetTrendLocationsParams\PlaceType;

/**
 * Returns the places X offers trends for. Pass a location's woeid to /x/trends. Each returned location costs 1 credit.
 *
 * @see XTwitterScraper\Services\XService::getTrendLocations()
 *
 * @phpstan-type XGetTrendLocationsParamsShape = array{
 *   country?: string|null,
 *   placeType?: PlaceType|value-of<PlaceType>|null,
 *   q?: string|null,
 *   limit?: int|null,
 *   fields?: string|null,
 *   omit?: string|null,
 * }
 */
final class XGetTrendLocationsParams implements BaseModel
{
    /** @use SdkModel<XGetTrendLocationsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Country name or 2-letter code, such as Turkey or TR. Case insensitive. Returns the country & its towns. X can add places, so Xquik takes up to 280 characters, the most a post holds.
     */
    #[Optional]
    public ?string $country;

    /**
     * Kind of place. Case insensitive. X labels a few towns unknown.
     *
     * @var value-of<PlaceType>|null $placeType
     */
    #[Optional(enum: PlaceType::class)]
    public ?string $placeType;

    /**
     * Text the location name contains, such as york. Case insensitive. Alias query. X can add places, so Xquik takes up to 280 characters, the most a post holds.
     */
    #[Optional]
    public ?string $q;

    /**
     * Maximum locations to return. Omit it for every match. A low credit balance can return fewer. Aliases pageSize, count, max_results, maxItems, max_items & per_page.
     */
    #[Optional]
    public ?int $limit;

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

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param PlaceType|value-of<PlaceType>|null $placeType
     */
    public static function with(?string $country = null, PlaceType|string|null $placeType = null, ?string $q = null, ?int $limit = null, ?string $fields = null, ?string $omit = null): self
    {
        $self = new self;

        null !== $country && $self['country'] = $country;
        null !== $placeType && $self['placeType'] = $placeType;
        null !== $q && $self['q'] = $q;
        null !== $limit && $self['limit'] = $limit;
        null !== $fields && $self['fields'] = $fields;
        null !== $omit && $self['omit'] = $omit;

        return $self;
    }

    /**
     * Country name or 2-letter code, such as Turkey or TR. Case insensitive. Returns the country & its towns. X can add places, so Xquik takes up to 280 characters, the most a post holds.
     */
    public function withCountry(?string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * Kind of place. Case insensitive. X labels a few towns unknown.
     *
     * @param PlaceType|value-of<PlaceType>|null $placeType
     */
    public function withPlaceType(PlaceType|string|null $placeType): self
    {
        $self = clone $this;
        $self['placeType'] = $placeType;

        return $self;
    }

    /**
     * Text the location name contains, such as york. Case insensitive. Alias query. X can add places, so Xquik takes up to 280 characters, the most a post holds.
     */
    public function withQ(?string $q): self
    {
        $self = clone $this;
        $self['q'] = $q;

        return $self;
    }

    /**
     * Maximum locations to return. Omit it for every match. A low credit balance can return fewer. Aliases pageSize, count, max_results, maxItems, max_items & per_page.
     */
    public function withLimit(?int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

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
