<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TweetPlaceShape = array{
 *   boundingBox?: array<string,mixed>|null,
 *   country?: string|null,
 *   countryCode?: string|null,
 *   fullName?: string|null,
 *   id?: string|null,
 *   name?: string|null,
 *   placeType?: string|null,
 *   url?: string|null,
 * }
 */
final class TweetPlace implements BaseModel
{
    /** @use SdkModel<TweetPlaceShape> */
    use SdkModel;

    /**
     * Public metadata whose fields X defines.
     *
     * @var array<string,mixed>|null $boundingBox
     */
    #[Optional(map: 'mixed')]
    public ?array $boundingBox;

    #[Optional]
    public ?string $country;

    #[Optional]
    public ?string $countryCode;

    #[Optional]
    public ?string $fullName;

    #[Optional]
    public ?string $id;

    #[Optional]
    public ?string $name;

    #[Optional]
    public ?string $placeType;

    #[Optional]
    public ?string $url;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,mixed>|null $boundingBox
     */
    public static function with(?array $boundingBox = null, ?string $country = null, ?string $countryCode = null, ?string $fullName = null, ?string $id = null, ?string $name = null, ?string $placeType = null, ?string $url = null): self
    {
        $self = new self;

        null !== $boundingBox && $self['boundingBox'] = $boundingBox;
        null !== $country && $self['country'] = $country;
        null !== $countryCode && $self['countryCode'] = $countryCode;
        null !== $fullName && $self['fullName'] = $fullName;
        null !== $id && $self['id'] = $id;
        null !== $name && $self['name'] = $name;
        null !== $placeType && $self['placeType'] = $placeType;
        null !== $url && $self['url'] = $url;

        return $self;
    }

    /**
     * Public metadata whose fields X defines.
     *
     * @param array<string,mixed>|null $boundingBox
     */
    public function withBoundingBox(?array $boundingBox): self
    {
        $self = clone $this;
        $self['boundingBox'] = $boundingBox;

        return $self;
    }

    public function withCountry(?string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    public function withCountryCode(?string $countryCode): self
    {
        $self = clone $this;
        $self['countryCode'] = $countryCode;

        return $self;
    }

    public function withFullName(?string $fullName): self
    {
        $self = clone $this;
        $self['fullName'] = $fullName;

        return $self;
    }

    public function withId(?string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withPlaceType(?string $placeType): self
    {
        $self = clone $this;
        $self['placeType'] = $placeType;

        return $self;
    }

    public function withUrl(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
