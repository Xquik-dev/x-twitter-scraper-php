<?php

declare(strict_types=1);

namespace XTwitterScraper\X\XGetArticleResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * X Article author profile fields returned when available.
 *
 * @phpstan-type AuthorShape = array{
 *   id: string,
 *   name: string,
 *   username: string,
 *   canDm?: bool|null,
 *   createdAt?: string|null,
 *   description?: string|null,
 *   favouritesCount?: int|null,
 *   followersCount?: int|null,
 *   followingCount?: int|null,
 *   isBlueVerified?: bool|null,
 *   isTranslator?: bool|null,
 *   isVerified?: bool|null,
 *   location?: string|null,
 *   mediaCount?: int|null,
 *   profileBannerURL?: string|null,
 *   profilePicture?: string|null,
 *   protected?: bool|null,
 *   statusesCount?: int|null,
 *   url?: string|null,
 * }
 */
final class Author implements BaseModel
{
    /** @use SdkModel<AuthorShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $name;

    #[Required]
    public string $username;

    #[Optional]
    public ?bool $canDm;

    #[Optional]
    public ?string $createdAt;

    #[Optional]
    public ?string $description;

    #[Optional]
    public ?int $favouritesCount;

    #[Optional]
    public ?int $followersCount;

    #[Optional]
    public ?int $followingCount;

    #[Optional]
    public ?bool $isBlueVerified;

    #[Optional]
    public ?bool $isTranslator;

    #[Optional]
    public ?bool $isVerified;

    #[Optional]
    public ?string $location;

    #[Optional]
    public ?int $mediaCount;

    #[Optional('profileBannerUrl')]
    public ?string $profileBannerURL;

    #[Optional]
    public ?string $profilePicture;

    #[Optional]
    public ?bool $protected;

    #[Optional]
    public ?int $statusesCount;

    #[Optional]
    public ?string $url;

    /**
     * `new Author()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Author::with(id: ..., name: ..., username: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Author)->withID(...)->withName(...)->withUsername(...)
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
    public static function with(
        string $id,
        string $name,
        string $username,
        ?bool $canDm = null,
        ?string $createdAt = null,
        ?string $description = null,
        ?int $favouritesCount = null,
        ?int $followersCount = null,
        ?int $followingCount = null,
        ?bool $isBlueVerified = null,
        ?bool $isTranslator = null,
        ?bool $isVerified = null,
        ?string $location = null,
        ?int $mediaCount = null,
        ?string $profileBannerURL = null,
        ?string $profilePicture = null,
        ?bool $protected = null,
        ?int $statusesCount = null,
        ?string $url = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['name'] = $name;
        $self['username'] = $username;

        null !== $canDm && $self['canDm'] = $canDm;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $description && $self['description'] = $description;
        null !== $favouritesCount && $self['favouritesCount'] = $favouritesCount;
        null !== $followersCount && $self['followersCount'] = $followersCount;
        null !== $followingCount && $self['followingCount'] = $followingCount;
        null !== $isBlueVerified && $self['isBlueVerified'] = $isBlueVerified;
        null !== $isTranslator && $self['isTranslator'] = $isTranslator;
        null !== $isVerified && $self['isVerified'] = $isVerified;
        null !== $location && $self['location'] = $location;
        null !== $mediaCount && $self['mediaCount'] = $mediaCount;
        null !== $profileBannerURL && $self['profileBannerURL'] = $profileBannerURL;
        null !== $profilePicture && $self['profilePicture'] = $profilePicture;
        null !== $protected && $self['protected'] = $protected;
        null !== $statusesCount && $self['statusesCount'] = $statusesCount;
        null !== $url && $self['url'] = $url;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withUsername(string $username): self
    {
        $self = clone $this;
        $self['username'] = $username;

        return $self;
    }

    public function withCanDm(bool $canDm): self
    {
        $self = clone $this;
        $self['canDm'] = $canDm;

        return $self;
    }

    public function withCreatedAt(string $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withFavouritesCount(int $favouritesCount): self
    {
        $self = clone $this;
        $self['favouritesCount'] = $favouritesCount;

        return $self;
    }

    public function withFollowersCount(int $followersCount): self
    {
        $self = clone $this;
        $self['followersCount'] = $followersCount;

        return $self;
    }

    public function withFollowingCount(int $followingCount): self
    {
        $self = clone $this;
        $self['followingCount'] = $followingCount;

        return $self;
    }

    public function withIsBlueVerified(bool $isBlueVerified): self
    {
        $self = clone $this;
        $self['isBlueVerified'] = $isBlueVerified;

        return $self;
    }

    public function withIsTranslator(bool $isTranslator): self
    {
        $self = clone $this;
        $self['isTranslator'] = $isTranslator;

        return $self;
    }

    public function withIsVerified(bool $isVerified): self
    {
        $self = clone $this;
        $self['isVerified'] = $isVerified;

        return $self;
    }

    public function withLocation(string $location): self
    {
        $self = clone $this;
        $self['location'] = $location;

        return $self;
    }

    public function withMediaCount(int $mediaCount): self
    {
        $self = clone $this;
        $self['mediaCount'] = $mediaCount;

        return $self;
    }

    public function withProfileBannerURL(string $profileBannerURL): self
    {
        $self = clone $this;
        $self['profileBannerURL'] = $profileBannerURL;

        return $self;
    }

    public function withProfilePicture(string $profilePicture): self
    {
        $self = clone $this;
        $self['profilePicture'] = $profilePicture;

        return $self;
    }

    public function withProtected(bool $protected): self
    {
        $self = clone $this;
        $self['protected'] = $protected;

        return $self;
    }

    public function withStatusesCount(int $statusesCount): self
    {
        $self = clone $this;
        $self['statusesCount'] = $statusesCount;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
