<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Users;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Users\UserRetrieveFollowingParams\Mode;

/**
 * List accounts a user follows.
 *
 * @see XTwitterScraper\Services\X\UsersService::retrieveFollowing()
 *
 * @phpstan-type UserRetrieveFollowingParamsShape = array{
 *   after?: string|null,
 *   bioContains?: string|null,
 *   cursor?: string|null,
 *   hasLocation?: bool|null,
 *   hasWebsite?: bool|null,
 *   limit?: int|null,
 *   locationContains?: string|null,
 *   maxFollowers?: int|null,
 *   maxFollowing?: int|null,
 *   maxStatuses?: int|null,
 *   minAccountAgeDays?: int|null,
 *   minFollowers?: int|null,
 *   minFollowing?: int|null,
 *   minStatuses?: int|null,
 *   mode?: null|Mode|value-of<Mode>,
 *   pageSize?: int|null,
 *   usernameContains?: string|null,
 *   verifiedOnly?: bool|null,
 *   verifiedType?: string|null,
 * }
 */
final class UserRetrieveFollowingParams implements BaseModel
{
    /** @use SdkModel<UserRetrieveFollowingParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Deprecated following cursor alias. Prefer cursor.
     */
    #[Optional]
    public ?string $after;

    /**
     * Match any comma-separated or line-separated bio term, ignoring case.
     */
    #[Optional]
    public ?string $bioContains;

    /**
     * Cursor from the previous response. Xquik cursors resume automatic coverage. Existing unprefixed cursors keep legacy standard behavior.
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
     * Legacy page-size alias outside explicit coverage mode. Coverage accepts 1-10000. Prefer pageSize.
     */
    #[Optional]
    public ?int $limit;

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
     * Omit mode for resumable maximum coverage. Standard keeps legacy pagination. Coverage returns diagnostics once and rejects cursors.
     *
     * @var value-of<Mode>|null $mode
     */
    #[Optional(enum: Mode::class)]
    public ?string $mode;

    /**
     * Maximum user profiles: automatic 300; standard 200. Sources return fewer profiles. Continue with has_next_page.
     */
    #[Optional]
    public ?int $pageSize;

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

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Mode|value-of<Mode>|null $mode
     */
    public static function with(
        ?string $after = null,
        ?string $bioContains = null,
        ?string $cursor = null,
        ?bool $hasLocation = null,
        ?bool $hasWebsite = null,
        ?int $limit = null,
        ?string $locationContains = null,
        ?int $maxFollowers = null,
        ?int $maxFollowing = null,
        ?int $maxStatuses = null,
        ?int $minAccountAgeDays = null,
        ?int $minFollowers = null,
        ?int $minFollowing = null,
        ?int $minStatuses = null,
        Mode|string|null $mode = null,
        ?int $pageSize = null,
        ?string $usernameContains = null,
        ?bool $verifiedOnly = null,
        ?string $verifiedType = null,
    ): self {
        $self = new self;

        null !== $after && $self['after'] = $after;
        null !== $bioContains && $self['bioContains'] = $bioContains;
        null !== $cursor && $self['cursor'] = $cursor;
        null !== $hasLocation && $self['hasLocation'] = $hasLocation;
        null !== $hasWebsite && $self['hasWebsite'] = $hasWebsite;
        null !== $limit && $self['limit'] = $limit;
        null !== $locationContains && $self['locationContains'] = $locationContains;
        null !== $maxFollowers && $self['maxFollowers'] = $maxFollowers;
        null !== $maxFollowing && $self['maxFollowing'] = $maxFollowing;
        null !== $maxStatuses && $self['maxStatuses'] = $maxStatuses;
        null !== $minAccountAgeDays && $self['minAccountAgeDays'] = $minAccountAgeDays;
        null !== $minFollowers && $self['minFollowers'] = $minFollowers;
        null !== $minFollowing && $self['minFollowing'] = $minFollowing;
        null !== $minStatuses && $self['minStatuses'] = $minStatuses;
        null !== $mode && $self['mode'] = $mode;
        null !== $pageSize && $self['pageSize'] = $pageSize;
        null !== $usernameContains && $self['usernameContains'] = $usernameContains;
        null !== $verifiedOnly && $self['verifiedOnly'] = $verifiedOnly;
        null !== $verifiedType && $self['verifiedType'] = $verifiedType;

        return $self;
    }

    /**
     * Deprecated following cursor alias. Prefer cursor.
     */
    public function withAfter(string $after): self
    {
        $self = clone $this;
        $self['after'] = $after;

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
     * Cursor from the previous response. Xquik cursors resume automatic coverage. Existing unprefixed cursors keep legacy standard behavior.
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
     * Legacy page-size alias outside explicit coverage mode. Coverage accepts 1-10000. Prefer pageSize.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

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
     * Omit mode for resumable maximum coverage. Standard keeps legacy pagination. Coverage returns diagnostics once and rejects cursors.
     *
     * @param Mode|value-of<Mode> $mode
     */
    public function withMode(Mode|string $mode): self
    {
        $self = clone $this;
        $self['mode'] = $mode;

        return $self;
    }

    /**
     * Maximum user profiles: automatic 300; standard 200. Sources return fewer profiles. Continue with has_next_page.
     */
    public function withPageSize(int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

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
