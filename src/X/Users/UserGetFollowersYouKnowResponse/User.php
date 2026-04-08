<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Users\UserGetFollowersYouKnowResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * X user profile with bio, follower counts, and verification status.
 *
 * @phpstan-type UserShape = array{
 *   id: string,
 *   name: string,
 *   username: string,
 *   createdAt?: string|null,
 *   description?: string|null,
 *   followers?: int|null,
 *   following?: int|null,
 *   location?: string|null,
 *   profilePicture?: string|null,
 *   statusesCount?: int|null,
 *   verified?: bool|null,
 * }
 */
final class User implements BaseModel
{
    /** @use SdkModel<UserShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $name;

    #[Required]
    public string $username;

    #[Optional]
    public ?string $createdAt;

    #[Optional]
    public ?string $description;

    #[Optional]
    public ?int $followers;

    #[Optional]
    public ?int $following;

    #[Optional]
    public ?string $location;

    #[Optional]
    public ?string $profilePicture;

    #[Optional]
    public ?int $statusesCount;

    #[Optional]
    public ?bool $verified;

    /**
     * `new User()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * User::with(id: ..., name: ..., username: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new User)->withID(...)->withName(...)->withUsername(...)
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
        ?string $createdAt = null,
        ?string $description = null,
        ?int $followers = null,
        ?int $following = null,
        ?string $location = null,
        ?string $profilePicture = null,
        ?int $statusesCount = null,
        ?bool $verified = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['name'] = $name;
        $self['username'] = $username;

        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $description && $self['description'] = $description;
        null !== $followers && $self['followers'] = $followers;
        null !== $following && $self['following'] = $following;
        null !== $location && $self['location'] = $location;
        null !== $profilePicture && $self['profilePicture'] = $profilePicture;
        null !== $statusesCount && $self['statusesCount'] = $statusesCount;
        null !== $verified && $self['verified'] = $verified;

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

    public function withFollowers(int $followers): self
    {
        $self = clone $this;
        $self['followers'] = $followers;

        return $self;
    }

    public function withFollowing(int $following): self
    {
        $self = clone $this;
        $self['following'] = $following;

        return $self;
    }

    public function withLocation(string $location): self
    {
        $self = clone $this;
        $self['location'] = $location;

        return $self;
    }

    public function withProfilePicture(string $profilePicture): self
    {
        $self = clone $this;
        $self['profilePicture'] = $profilePicture;

        return $self;
    }

    public function withStatusesCount(int $statusesCount): self
    {
        $self = clone $this;
        $self['statusesCount'] = $statusesCount;

        return $self;
    }

    public function withVerified(bool $verified): self
    {
        $self = clone $this;
        $self['verified'] = $verified;

        return $self;
    }
}
