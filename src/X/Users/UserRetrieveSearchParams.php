<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Users;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Search users by name or username.
 *
 * @see XTwitterScraper\Services\X\UsersService::retrieveSearch()
 *
 * @phpstan-type UserRetrieveSearchParamsShape = array{
 *   q: string,
 *   bioContains?: string|null,
 *   cursor?: string|null,
 *   hasLocation?: bool|null,
 *   hasWebsite?: bool|null,
 *   locationContains?: string|null,
 *   maxFollowers?: int|null,
 *   maxFollowing?: int|null,
 *   maxStatuses?: int|null,
 *   minAccountAgeDays?: int|null,
 *   minFollowers?: int|null,
 *   minFollowing?: int|null,
 *   minStatuses?: int|null,
 *   usernameContains?: string|null,
 *   verifiedOnly?: bool|null,
 *   verifiedType?: string|null,
 * }
 */
final class UserRetrieveSearchParams implements BaseModel
{
    /** @use SdkModel<UserRetrieveSearchParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * User search query.
     */
    #[Required]
    public string $q;

    /**
     * Match any comma-separated or line-separated bio term, ignoring case.
     */
    #[Optional]
    public ?string $bioContains;

    /**
     * Pagination cursor for user search.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Only return profiles with a location.
     */
    #[Optional]
    public ?bool $hasLocation;

    /**
     * Only return profiles with a website.
     */
    #[Optional]
    public ?bool $hasWebsite;

    /**
     * Match a location substring, ignoring case.
     */
    #[Optional]
    public ?string $locationContains;

    /**
     * Maximum follower count. Missing counts pass this maximum.
     */
    #[Optional]
    public ?int $maxFollowers;

    /**
     * Maximum following count.
     */
    #[Optional]
    public ?int $maxFollowing;

    /**
     * Maximum post count. maxPosts is also accepted.
     */
    #[Optional]
    public ?int $maxStatuses;

    /**
     * Minimum account age in whole days.
     */
    #[Optional]
    public ?int $minAccountAgeDays;

    /**
     * Minimum follower count. Filtering happens before billing.
     */
    #[Optional]
    public ?int $minFollowers;

    /**
     * Minimum following count.
     */
    #[Optional]
    public ?int $minFollowing;

    /**
     * Minimum post count. minPosts is also accepted.
     */
    #[Optional]
    public ?int $minStatuses;

    /**
     * Match a username substring, ignoring case.
     */
    #[Optional]
    public ?string $usernameContains;

    /**
     * Only return verified profiles.
     */
    #[Optional]
    public ?bool $verifiedOnly;

    /**
     * Match the verification type exactly, ignoring case.
     */
    #[Optional]
    public ?string $verifiedType;

    /**
     * `new UserRetrieveSearchParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserRetrieveSearchParams::with(q: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserRetrieveSearchParams)->withQ(...)
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
        string $q,
        ?string $bioContains = null,
        ?string $cursor = null,
        ?bool $hasLocation = null,
        ?bool $hasWebsite = null,
        ?string $locationContains = null,
        ?int $maxFollowers = null,
        ?int $maxFollowing = null,
        ?int $maxStatuses = null,
        ?int $minAccountAgeDays = null,
        ?int $minFollowers = null,
        ?int $minFollowing = null,
        ?int $minStatuses = null,
        ?string $usernameContains = null,
        ?bool $verifiedOnly = null,
        ?string $verifiedType = null,
    ): self {
        $self = new self;

        $self['q'] = $q;

        null !== $bioContains && $self['bioContains'] = $bioContains;
        null !== $cursor && $self['cursor'] = $cursor;
        null !== $hasLocation && $self['hasLocation'] = $hasLocation;
        null !== $hasWebsite && $self['hasWebsite'] = $hasWebsite;
        null !== $locationContains && $self['locationContains'] = $locationContains;
        null !== $maxFollowers && $self['maxFollowers'] = $maxFollowers;
        null !== $maxFollowing && $self['maxFollowing'] = $maxFollowing;
        null !== $maxStatuses && $self['maxStatuses'] = $maxStatuses;
        null !== $minAccountAgeDays && $self['minAccountAgeDays'] = $minAccountAgeDays;
        null !== $minFollowers && $self['minFollowers'] = $minFollowers;
        null !== $minFollowing && $self['minFollowing'] = $minFollowing;
        null !== $minStatuses && $self['minStatuses'] = $minStatuses;
        null !== $usernameContains && $self['usernameContains'] = $usernameContains;
        null !== $verifiedOnly && $self['verifiedOnly'] = $verifiedOnly;
        null !== $verifiedType && $self['verifiedType'] = $verifiedType;

        return $self;
    }

    /**
     * User search query.
     */
    public function withQ(string $q): self
    {
        $self = clone $this;
        $self['q'] = $q;

        return $self;
    }

    /**
     * Match any comma-separated or line-separated bio term, ignoring case.
     */
    public function withBioContains(string $bioContains): self
    {
        $self = clone $this;
        $self['bioContains'] = $bioContains;

        return $self;
    }

    /**
     * Pagination cursor for user search.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Only return profiles with a location.
     */
    public function withHasLocation(bool $hasLocation): self
    {
        $self = clone $this;
        $self['hasLocation'] = $hasLocation;

        return $self;
    }

    /**
     * Only return profiles with a website.
     */
    public function withHasWebsite(bool $hasWebsite): self
    {
        $self = clone $this;
        $self['hasWebsite'] = $hasWebsite;

        return $self;
    }

    /**
     * Match a location substring, ignoring case.
     */
    public function withLocationContains(string $locationContains): self
    {
        $self = clone $this;
        $self['locationContains'] = $locationContains;

        return $self;
    }

    /**
     * Maximum follower count. Missing counts pass this maximum.
     */
    public function withMaxFollowers(int $maxFollowers): self
    {
        $self = clone $this;
        $self['maxFollowers'] = $maxFollowers;

        return $self;
    }

    /**
     * Maximum following count.
     */
    public function withMaxFollowing(int $maxFollowing): self
    {
        $self = clone $this;
        $self['maxFollowing'] = $maxFollowing;

        return $self;
    }

    /**
     * Maximum post count. maxPosts is also accepted.
     */
    public function withMaxStatuses(int $maxStatuses): self
    {
        $self = clone $this;
        $self['maxStatuses'] = $maxStatuses;

        return $self;
    }

    /**
     * Minimum account age in whole days.
     */
    public function withMinAccountAgeDays(int $minAccountAgeDays): self
    {
        $self = clone $this;
        $self['minAccountAgeDays'] = $minAccountAgeDays;

        return $self;
    }

    /**
     * Minimum follower count. Filtering happens before billing.
     */
    public function withMinFollowers(int $minFollowers): self
    {
        $self = clone $this;
        $self['minFollowers'] = $minFollowers;

        return $self;
    }

    /**
     * Minimum following count.
     */
    public function withMinFollowing(int $minFollowing): self
    {
        $self = clone $this;
        $self['minFollowing'] = $minFollowing;

        return $self;
    }

    /**
     * Minimum post count. minPosts is also accepted.
     */
    public function withMinStatuses(int $minStatuses): self
    {
        $self = clone $this;
        $self['minStatuses'] = $minStatuses;

        return $self;
    }

    /**
     * Match a username substring, ignoring case.
     */
    public function withUsernameContains(string $usernameContains): self
    {
        $self = clone $this;
        $self['usernameContains'] = $usernameContains;

        return $self;
    }

    /**
     * Only return verified profiles.
     */
    public function withVerifiedOnly(bool $verifiedOnly): self
    {
        $self = clone $this;
        $self['verifiedOnly'] = $verifiedOnly;

        return $self;
    }

    /**
     * Match the verification type exactly, ignoring case.
     */
    public function withVerifiedType(string $verifiedType): self
    {
        $self = clone $this;
        $self['verifiedType'] = $verifiedType;

        return $self;
    }
}
