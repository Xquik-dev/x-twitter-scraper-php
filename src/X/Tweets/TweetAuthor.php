<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Tweet author profile. The lookup route always includes follower count and verification state. Other profile fields appear when available.
 *
 * @phpstan-type TweetAuthorShape = array{
 *   id: string,
 *   name: string,
 *   username: string,
 *   automatedBy?: string|null,
 *   canDm?: bool|null,
 *   communityRole?: string|null,
 *   coverPicture?: string|null,
 *   createdAt?: string|null,
 *   description?: string|null,
 *   favouritesCount?: int|null,
 *   followers?: int|null,
 *   following?: int|null,
 *   hasCustomTimelines?: bool|null,
 *   isAutomated?: bool|null,
 *   isBlueVerified?: bool|null,
 *   isTranslator?: bool|null,
 *   isVerified?: bool|null,
 *   location?: string|null,
 *   mediaCount?: int|null,
 *   pinnedTweetIDs?: list<string>|null,
 *   possiblySensitive?: bool|null,
 *   profileBio?: array<string,mixed>|null,
 *   profileBannerURL?: string|null,
 *   profilePicture?: string|null,
 *   protected?: bool|null,
 *   statusesCount?: int|null,
 *   unavailable?: bool|null,
 *   unavailableReason?: string|null,
 *   url?: string|null,
 *   verified?: bool|null,
 *   verifiedType?: string|null,
 *   viewerFollowedBy?: bool|null,
 *   viewerFollowing?: bool|null,
 *   withheldInCountries?: list<string>|null,
 * }
 */
final class TweetAuthor implements BaseModel
{
    /** @use SdkModel<TweetAuthorShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $name;

    #[Required]
    public string $username;

    #[Optional]
    public ?string $automatedBy;

    #[Optional]
    public ?bool $canDm;

    /**
     * Community role when returned by community member reads.
     */
    #[Optional]
    public ?string $communityRole;

    #[Optional]
    public ?string $coverPicture;

    #[Optional]
    public ?string $createdAt;

    #[Optional]
    public ?string $description;

    #[Optional]
    public ?int $favouritesCount;

    #[Optional]
    public ?int $followers;

    #[Optional]
    public ?int $following;

    #[Optional]
    public ?bool $hasCustomTimelines;

    #[Optional]
    public ?bool $isAutomated;

    /**
     * Whether X shows a blue verification badge.
     */
    #[Optional]
    public ?bool $isBlueVerified;

    #[Optional]
    public ?bool $isTranslator;

    /**
     * Whether X marks the profile as verified.
     */
    #[Optional]
    public ?bool $isVerified;

    #[Optional]
    public ?string $location;

    #[Optional]
    public ?int $mediaCount;

    /** @var list<string>|null $pinnedTweetIDs */
    #[Optional('pinnedTweetIds', list: 'string')]
    public ?array $pinnedTweetIDs;

    #[Optional]
    public ?bool $possiblySensitive;

    /**
     * Structured profile bio with entity annotations.
     *
     * @var array<string,mixed>|null $profileBio
     */
    #[Optional('profile_bio', map: 'mixed')]
    public ?array $profileBio;

    /**
     * Original X profile banner field when available.
     */
    #[Optional('profileBannerUrl')]
    public ?string $profileBannerURL;

    #[Optional]
    public ?string $profilePicture;

    /**
     * Whether the profile protects its posts.
     */
    #[Optional]
    public ?bool $protected;

    #[Optional]
    public ?int $statusesCount;

    #[Optional]
    public ?bool $unavailable;

    #[Optional]
    public ?string $unavailableReason;

    #[Optional]
    public ?string $url;

    #[Optional]
    public ?bool $verified;

    #[Optional]
    public ?string $verifiedType;

    /**
     * Whether this profile follows the authenticated viewer.
     */
    #[Optional]
    public ?bool $viewerFollowedBy;

    /**
     * Whether the authenticated viewer follows this profile.
     */
    #[Optional]
    public ?bool $viewerFollowing;

    /** @var list<string>|null $withheldInCountries */
    #[Optional(list: 'string')]
    public ?array $withheldInCountries;

    /**
     * `new TweetAuthor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetAuthor::with(id: ..., name: ..., username: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetAuthor)->withID(...)->withName(...)->withUsername(...)
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
     * @param list<string>|null $pinnedTweetIDs
     * @param array<string,mixed>|null $profileBio
     * @param list<string>|null $withheldInCountries
     */
    public static function with(
        string $id,
        string $name,
        string $username,
        ?string $automatedBy = null,
        ?bool $canDm = null,
        ?string $communityRole = null,
        ?string $coverPicture = null,
        ?string $createdAt = null,
        ?string $description = null,
        ?int $favouritesCount = null,
        ?int $followers = null,
        ?int $following = null,
        ?bool $hasCustomTimelines = null,
        ?bool $isAutomated = null,
        ?bool $isBlueVerified = null,
        ?bool $isTranslator = null,
        ?bool $isVerified = null,
        ?string $location = null,
        ?int $mediaCount = null,
        ?array $pinnedTweetIDs = null,
        ?bool $possiblySensitive = null,
        ?array $profileBio = null,
        ?string $profileBannerURL = null,
        ?string $profilePicture = null,
        ?bool $protected = null,
        ?int $statusesCount = null,
        ?bool $unavailable = null,
        ?string $unavailableReason = null,
        ?string $url = null,
        ?bool $verified = null,
        ?string $verifiedType = null,
        ?bool $viewerFollowedBy = null,
        ?bool $viewerFollowing = null,
        ?array $withheldInCountries = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['name'] = $name;
        $self['username'] = $username;

        null !== $automatedBy && $self['automatedBy'] = $automatedBy;
        null !== $canDm && $self['canDm'] = $canDm;
        null !== $communityRole && $self['communityRole'] = $communityRole;
        null !== $coverPicture && $self['coverPicture'] = $coverPicture;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $description && $self['description'] = $description;
        null !== $favouritesCount && $self['favouritesCount'] = $favouritesCount;
        null !== $followers && $self['followers'] = $followers;
        null !== $following && $self['following'] = $following;
        null !== $hasCustomTimelines && $self['hasCustomTimelines'] = $hasCustomTimelines;
        null !== $isAutomated && $self['isAutomated'] = $isAutomated;
        null !== $isBlueVerified && $self['isBlueVerified'] = $isBlueVerified;
        null !== $isTranslator && $self['isTranslator'] = $isTranslator;
        null !== $isVerified && $self['isVerified'] = $isVerified;
        null !== $location && $self['location'] = $location;
        null !== $mediaCount && $self['mediaCount'] = $mediaCount;
        null !== $pinnedTweetIDs && $self['pinnedTweetIDs'] = $pinnedTweetIDs;
        null !== $possiblySensitive && $self['possiblySensitive'] = $possiblySensitive;
        null !== $profileBio && $self['profileBio'] = $profileBio;
        null !== $profileBannerURL && $self['profileBannerURL'] = $profileBannerURL;
        null !== $profilePicture && $self['profilePicture'] = $profilePicture;
        null !== $protected && $self['protected'] = $protected;
        null !== $statusesCount && $self['statusesCount'] = $statusesCount;
        null !== $unavailable && $self['unavailable'] = $unavailable;
        null !== $unavailableReason && $self['unavailableReason'] = $unavailableReason;
        null !== $url && $self['url'] = $url;
        null !== $verified && $self['verified'] = $verified;
        null !== $verifiedType && $self['verifiedType'] = $verifiedType;
        null !== $viewerFollowedBy && $self['viewerFollowedBy'] = $viewerFollowedBy;
        null !== $viewerFollowing && $self['viewerFollowing'] = $viewerFollowing;
        null !== $withheldInCountries && $self['withheldInCountries'] = $withheldInCountries;

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

    public function withAutomatedBy(string $automatedBy): self
    {
        $self = clone $this;
        $self['automatedBy'] = $automatedBy;

        return $self;
    }

    public function withCanDm(bool $canDm): self
    {
        $self = clone $this;
        $self['canDm'] = $canDm;

        return $self;
    }

    /**
     * Community role when returned by community member reads.
     */
    public function withCommunityRole(string $communityRole): self
    {
        $self = clone $this;
        $self['communityRole'] = $communityRole;

        return $self;
    }

    public function withCoverPicture(string $coverPicture): self
    {
        $self = clone $this;
        $self['coverPicture'] = $coverPicture;

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

    public function withHasCustomTimelines(bool $hasCustomTimelines): self
    {
        $self = clone $this;
        $self['hasCustomTimelines'] = $hasCustomTimelines;

        return $self;
    }

    public function withIsAutomated(bool $isAutomated): self
    {
        $self = clone $this;
        $self['isAutomated'] = $isAutomated;

        return $self;
    }

    /**
     * Whether X shows a blue verification badge.
     */
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

    /**
     * Whether X marks the profile as verified.
     */
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

    /**
     * @param list<string> $pinnedTweetIDs
     */
    public function withPinnedTweetIDs(array $pinnedTweetIDs): self
    {
        $self = clone $this;
        $self['pinnedTweetIDs'] = $pinnedTweetIDs;

        return $self;
    }

    public function withPossiblySensitive(bool $possiblySensitive): self
    {
        $self = clone $this;
        $self['possiblySensitive'] = $possiblySensitive;

        return $self;
    }

    /**
     * Structured profile bio with entity annotations.
     *
     * @param array<string,mixed> $profileBio
     */
    public function withProfileBio(array $profileBio): self
    {
        $self = clone $this;
        $self['profileBio'] = $profileBio;

        return $self;
    }

    /**
     * Original X profile banner field when available.
     */
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

    /**
     * Whether the profile protects its posts.
     */
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

    public function withUnavailable(bool $unavailable): self
    {
        $self = clone $this;
        $self['unavailable'] = $unavailable;

        return $self;
    }

    public function withUnavailableReason(string $unavailableReason): self
    {
        $self = clone $this;
        $self['unavailableReason'] = $unavailableReason;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    public function withVerified(bool $verified): self
    {
        $self = clone $this;
        $self['verified'] = $verified;

        return $self;
    }

    public function withVerifiedType(string $verifiedType): self
    {
        $self = clone $this;
        $self['verifiedType'] = $verifiedType;

        return $self;
    }

    /**
     * Whether this profile follows the authenticated viewer.
     */
    public function withViewerFollowedBy(bool $viewerFollowedBy): self
    {
        $self = clone $this;
        $self['viewerFollowedBy'] = $viewerFollowedBy;

        return $self;
    }

    /**
     * Whether the authenticated viewer follows this profile.
     */
    public function withViewerFollowing(bool $viewerFollowing): self
    {
        $self = clone $this;
        $self['viewerFollowing'] = $viewerFollowing;

        return $self;
    }

    /**
     * @param list<string> $withheldInCountries
     */
    public function withWithheldInCountries(array $withheldInCountries): self
    {
        $self = clone $this;
        $self['withheldInCountries'] = $withheldInCountries;

        return $self;
    }
}
