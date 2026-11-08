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
 * @phpstan-type TrendLocationShape = array{
 *   woeid: int,
 *   name: string,
 *   country: string|null,
 *   countryCode: string|null,
 *   placeType: string|null,
 *   placeTypeCode: int|null,
 *   parentWoeid: int|null,
 *   url: string|null,
 * }
 */
final class TrendLocation implements BaseModel
{
    /** @use SdkModel<TrendLocationShape> */
    use SdkModel;

    /**
     * Location ID. Pass it as woeid to /x/trends.
     */
    #[Required]
    public int $woeid;

    #[Required]
    public string $name;

    /**
     * Country name. Null for Worldwide.
     */
    #[Required]
    public ?string $country;

    /**
     * 2-letter country code. Null for Worldwide.
     */
    #[Required]
    public ?string $countryCode;

    /**
     * X's kind of place. Town, Country, Supername for Worldwide, or Unknown.
     */
    #[Required]
    public ?string $placeType;

    /**
     * X's numeric code for the kind of place.
     */
    #[Required]
    public ?int $placeTypeCode;

    /**
     * WOEID of the country or region above it. Null for Worldwide.
     */
    #[Required]
    public ?int $parentWoeid;

    /**
     * X's legacy Yahoo GeoPlanet reference. It may not resolve.
     */
    #[Required]
    public ?string $url;

    /**
     * `new TrendLocation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TrendLocation::with(woeid: ..., name: ..., country: ..., countryCode: ..., placeType: ..., placeTypeCode: ..., parentWoeid: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TrendLocation)->withWoeid(...)->withName(...)->withCountry(...)->withCountryCode(...)->withPlaceType(...)->withPlaceTypeCode(...)->withParentWoeid(...)->withUrl(...)
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
     */
    public static function with(int $woeid, string $name, ?string $country, ?string $countryCode, ?string $placeType, ?int $placeTypeCode, ?int $parentWoeid, ?string $url): self
    {
        $self = new self;

        $self['woeid'] = $woeid;
        $self['name'] = $name;
        $self['country'] = $country;
        $self['countryCode'] = $countryCode;
        $self['placeType'] = $placeType;
        $self['placeTypeCode'] = $placeTypeCode;
        $self['parentWoeid'] = $parentWoeid;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Location ID. Pass it as woeid to /x/trends.
     */
    public function withWoeid(int $woeid): self
    {
        $self = clone $this;
        $self['woeid'] = $woeid;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Country name. Null for Worldwide.
     */
    public function withCountry(?string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * 2-letter country code. Null for Worldwide.
     */
    public function withCountryCode(?string $countryCode): self
    {
        $self = clone $this;
        $self['countryCode'] = $countryCode;

        return $self;
    }

    /**
     * X's kind of place. Town, Country, Supername for Worldwide, or Unknown.
     */
    public function withPlaceType(?string $placeType): self
    {
        $self = clone $this;
        $self['placeType'] = $placeType;

        return $self;
    }

    /**
     * X's numeric code for the kind of place.
     */
    public function withPlaceTypeCode(?int $placeTypeCode): self
    {
        $self = clone $this;
        $self['placeTypeCode'] = $placeTypeCode;

        return $self;
    }

    /**
     * WOEID of the country or region above it. Null for Worldwide.
     */
    public function withParentWoeid(?int $parentWoeid): self
    {
        $self = clone $this;
        $self['parentWoeid'] = $parentWoeid;

        return $self;
    }

    /**
     * X's legacy Yahoo GeoPlanet reference. It may not resolve.
     */
    public function withUrl(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
