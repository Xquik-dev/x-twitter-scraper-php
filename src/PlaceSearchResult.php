<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\PlaceSearchResult\BoundingBox;
use XTwitterScraper\SearchTweet\Place;

/**
 * @phpstan-type PlaceSearchResultShape = array{
 *   id: string,
 *   name: string,
 *   fullName: string|null,
 *   country: string|null,
 *   countryCode: string|null,
 *   placeType: string|null,
 *   url: string|null,
 *   centroid: list<float>|null,
 *   boundingBox: BoundingBox|array<string,mixed>|null,
 *   attributes: array<string,mixed>,
 *   containedWithin: list<Place|array<string,mixed>>,
 * }
 */
final class PlaceSearchResult implements BaseModel
{
    /** @use SdkModel<PlaceSearchResultShape> */
    use SdkModel;

    /**
     * Place ID. Pass it as place to /x/tweets/search.
     */
    #[Required]
    public string $id;

    /**
     * Short name of the place.
     */
    #[Required]
    public string $name;

    /**
     * Name with the region or country around the place.
     */
    #[Required]
    public ?string $fullName;

    /**
     * Country the place lies in.
     */
    #[Required]
    public ?string $country;

    /**
     * 2-letter code of the country the place lies in.
     */
    #[Required]
    public ?string $countryCode;

    /**
     * X's kind of place, such as city, admin, neighborhood, poi or country.
     */
    #[Required]
    public ?string $placeType;

    /**
     * X's own reference URL for the place.
     */
    #[Required]
    public ?string $url;

    /**
     * Center of the place. Longitude, then latitude.
     *
     * @var list<float>|null $centroid
     */
    #[Required(list: 'float')]
    public ?array $centroid;

    /**
     * Outline of the place as GeoJSON. Each point holds longitude, then latitude.
     */
    #[Required]
    public ?BoundingBox $boundingBox;

    /**
     * Extra details X attaches to some places. Often empty.
     *
     * @var array<string,mixed> $attributes
     */
    #[Required(map: 'mixed')]
    public array $attributes;

    /**
     * Larger places this place lies in. Often 1.
     *
     * @var list<Place> $containedWithin
     */
    #[Required(list: Place::class)]
    public array $containedWithin;

    /**
     * `new PlaceSearchResult()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PlaceSearchResult::with(id: ..., name: ..., fullName: ..., country: ..., countryCode: ..., placeType: ..., url: ..., centroid: ..., boundingBox: ..., attributes: ..., containedWithin: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PlaceSearchResult)->withId(...)->withName(...)->withFullName(...)->withCountry(...)->withCountryCode(...)->withPlaceType(...)->withUrl(...)->withCentroid(...)->withBoundingBox(...)->withAttributes(...)->withContainedWithin(...)
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
     * @param list<float>|null $centroid
     * @param BoundingBox|array<string,mixed>|null $boundingBox
     * @param array<string,mixed> $attributes
     * @param list<Place|array<string,mixed>> $containedWithin
     */
    public static function with(string $id, string $name, ?string $fullName, ?string $country, ?string $countryCode, ?string $placeType, ?string $url, ?array $centroid, BoundingBox|array|null $boundingBox, array $attributes, array $containedWithin): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['name'] = $name;
        $self['fullName'] = $fullName;
        $self['country'] = $country;
        $self['countryCode'] = $countryCode;
        $self['placeType'] = $placeType;
        $self['url'] = $url;
        $self['centroid'] = $centroid;
        $self['boundingBox'] = $boundingBox;
        $self['attributes'] = $attributes;
        $self['containedWithin'] = $containedWithin;

        return $self;
    }

    /**
     * Place ID. Pass it as place to /x/tweets/search.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Short name of the place.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Name with the region or country around the place.
     */
    public function withFullName(?string $fullName): self
    {
        $self = clone $this;
        $self['fullName'] = $fullName;

        return $self;
    }

    /**
     * Country the place lies in.
     */
    public function withCountry(?string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * 2-letter code of the country the place lies in.
     */
    public function withCountryCode(?string $countryCode): self
    {
        $self = clone $this;
        $self['countryCode'] = $countryCode;

        return $self;
    }

    /**
     * X's kind of place, such as city, admin, neighborhood, poi or country.
     */
    public function withPlaceType(?string $placeType): self
    {
        $self = clone $this;
        $self['placeType'] = $placeType;

        return $self;
    }

    /**
     * X's own reference URL for the place.
     */
    public function withUrl(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Center of the place. Longitude, then latitude.
     *
     * @param list<float>|null $centroid
     */
    public function withCentroid(?array $centroid): self
    {
        $self = clone $this;
        $self['centroid'] = $centroid;

        return $self;
    }

    /**
     * Outline of the place as GeoJSON. Each point holds longitude, then latitude.
     *
     * @param BoundingBox|array<string,mixed>|null $boundingBox
     */
    public function withBoundingBox(BoundingBox|array|null $boundingBox): self
    {
        $self = clone $this;
        $self['boundingBox'] = $boundingBox;

        return $self;
    }

    /**
     * Extra details X attaches to some places. Often empty.
     *
     * @param array<string,mixed> $attributes
     */
    public function withAttributes(array $attributes): self
    {
        $self = clone $this;
        $self['attributes'] = $attributes;

        return $self;
    }

    /**
     * Larger places this place lies in. Often 1.
     *
     * @param list<Place|array<string,mixed>> $containedWithin
     */
    public function withContainedWithin(array $containedWithin): self
    {
        $self = clone $this;
        $self['containedWithin'] = $containedWithin;

        return $self;
    }
}
