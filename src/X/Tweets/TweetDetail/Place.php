<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetDetail;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Public place metadata attached to a tweet.
 *
 * @phpstan-type PlaceShape = array{
 *   id?: string|null,
 *   boundingBox?: array<string,mixed>|null,
 *   country?: string|null,
 *   countryCode?: string|null,
 *   fullName?: string|null,
 *   name?: string|null,
 *   placeType?: string|null,
 *   url?: string|null,
 * }
 */
final class Place implements BaseModel
{
    /** @use SdkModel<PlaceShape> */
    use SdkModel;

    #[Optional]
    public ?string $id;

    /** @var array<string,mixed>|null $boundingBox */
    #[Optional(map: 'mixed')]
    public ?array $boundingBox;

    #[Optional]
    public ?string $country;

    #[Optional]
    public ?string $countryCode;

    #[Optional]
    public ?string $fullName;

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
    public static function with(
        ?string $id = null,
        ?array $boundingBox = null,
        ?string $country = null,
        ?string $countryCode = null,
        ?string $fullName = null,
        ?string $name = null,
        ?string $placeType = null,
        ?string $url = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $boundingBox && $self['boundingBox'] = $boundingBox;
        null !== $country && $self['country'] = $country;
        null !== $countryCode && $self['countryCode'] = $countryCode;
        null !== $fullName && $self['fullName'] = $fullName;
        null !== $name && $self['name'] = $name;
        null !== $placeType && $self['placeType'] = $placeType;
        null !== $url && $self['url'] = $url;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param array<string,mixed> $boundingBox
     */
    public function withBoundingBox(array $boundingBox): self
    {
        $self = clone $this;
        $self['boundingBox'] = $boundingBox;

        return $self;
    }

    public function withCountry(string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    public function withCountryCode(string $countryCode): self
    {
        $self = clone $this;
        $self['countryCode'] = $countryCode;

        return $self;
    }

    public function withFullName(string $fullName): self
    {
        $self = clone $this;
        $self['fullName'] = $fullName;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withPlaceType(string $placeType): self
    {
        $self = clone $this;
        $self['placeType'] = $placeType;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
