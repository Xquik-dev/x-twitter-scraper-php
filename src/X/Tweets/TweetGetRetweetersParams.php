<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * List users who retweeted a tweet.
 *
 * @see XTwitterScraper\Services\X\TweetsService::getRetweeters()
 *
 * @phpstan-type TweetGetRetweetersParamsShape = array{
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
 *   pageSize?: int|null,
 *   usernameContains?: string|null,
 *   verifiedOnly?: bool|null,
 *   verifiedType?: string|null,
 *   includeRetweetTimestamp?: bool|null,
 *   blueVerifiedOnly?: bool|null,
 *   hasEmail?: bool|null,
 *   businessEmailOnly?: bool|null,
 *   emailDomains?: string|null,
 *   enrichProfiles?: bool|null,
 *   fields?: string|null,
 *   omit?: string|null,
 * }
 */
final class TweetGetRetweetersParams implements BaseModel
{
    /** @use SdkModel<TweetGetRetweetersParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Match any comma-separated or line-separated bio term, ignoring case.
     */
    #[Optional]
    public ?string $bioContains;

    /**
     * Pagination cursor for retweeters.
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
     * Maximum user profiles requested from this page (20-200, default 200). Source, filters, or credits can return fewer profiles. Keep requesting next_cursor while has_next_page is true. Deprecated aliases remain accepted.
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

    /**
     * Look up repost event times.
     */
    #[Optional]
    public ?bool $includeRetweetTimestamp;

    /**
     * Only return profiles X marks as blue verified. X marks many business & government accounts blue too. Use verifiedType for 1 badge type.
     */
    #[Optional]
    public ?bool $blueVerifiedOnly;

    /**
     * Only return profiles that publish an email.
     */
    #[Optional]
    public ?bool $hasEmail;

    /**
     * Only return profiles that publish an email outside free webmail, such as Gmail.
     */
    #[Optional]
    public ?bool $businessEmailOnly;

    /**
     * Only return profiles with an email at one of these domains. Separate domains with commas. Subdomains match.
     */
    #[Optional]
    public ?string $emailDomains;

    /**
     * Add each row's full profile, as GET /x/users/{id} returns it. Pages take several seconds longer.
     */
    #[Optional]
    public ?bool $enrichProfiles;

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
     */
    public static function with(
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
        ?int $pageSize = null,
        ?string $usernameContains = null,
        ?bool $verifiedOnly = null,
        ?string $verifiedType = null,
        ?bool $includeRetweetTimestamp = null,
        ?bool $blueVerifiedOnly = null,
        ?bool $hasEmail = null,
        ?bool $businessEmailOnly = null,
        ?string $emailDomains = null,
        ?bool $enrichProfiles = null,
        ?string $fields = null,
        ?string $omit = null
    ): self {
        $self = new self;

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
        null !== $pageSize && $self['pageSize'] = $pageSize;
        null !== $usernameContains && $self['usernameContains'] = $usernameContains;
        null !== $verifiedOnly && $self['verifiedOnly'] = $verifiedOnly;
        null !== $verifiedType && $self['verifiedType'] = $verifiedType;

        null !== $includeRetweetTimestamp && $self['includeRetweetTimestamp'] = $includeRetweetTimestamp;

        null !== $blueVerifiedOnly && $self['blueVerifiedOnly'] = $blueVerifiedOnly;

        null !== $hasEmail && $self['hasEmail'] = $hasEmail;

        null !== $businessEmailOnly && $self['businessEmailOnly'] = $businessEmailOnly;

        null !== $emailDomains && $self['emailDomains'] = $emailDomains;

        null !== $enrichProfiles && $self['enrichProfiles'] = $enrichProfiles;

        null !== $fields && $self['fields'] = $fields;

        null !== $omit && $self['omit'] = $omit;

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
     * Pagination cursor for retweeters.
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
     * Maximum user profiles requested from this page (20-200, default 200). Source, filters, or credits can return fewer profiles. Keep requesting next_cursor while has_next_page is true. Deprecated aliases remain accepted.
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

    /**
     * Look up repost event times.
     */
    public function withIncludeRetweetTimestamp(?bool $includeRetweetTimestamp): self
    {
        $self = clone $this;
        $self['includeRetweetTimestamp'] = $includeRetweetTimestamp;

        return $self;
    }

    /**
     * Only return profiles X marks as blue verified. X marks many business & government accounts blue too. Use verifiedType for 1 badge type.
     */
    public function withBlueVerifiedOnly(?bool $blueVerifiedOnly): self
    {
        $self = clone $this;
        $self['blueVerifiedOnly'] = $blueVerifiedOnly;

        return $self;
    }

    /**
     * Only return profiles that publish an email.
     */
    public function withHasEmail(?bool $hasEmail): self
    {
        $self = clone $this;
        $self['hasEmail'] = $hasEmail;

        return $self;
    }

    /**
     * Only return profiles that publish an email outside free webmail, such as Gmail.
     */
    public function withBusinessEmailOnly(?bool $businessEmailOnly): self
    {
        $self = clone $this;
        $self['businessEmailOnly'] = $businessEmailOnly;

        return $self;
    }

    /**
     * Only return profiles with an email at one of these domains. Separate domains with commas. Subdomains match.
     */
    public function withEmailDomains(?string $emailDomains): self
    {
        $self = clone $this;
        $self['emailDomains'] = $emailDomains;

        return $self;
    }

    /**
     * Add each row's full profile, as GET /x/users/{id} returns it. Pages take several seconds longer.
     */
    public function withEnrichProfiles(?bool $enrichProfiles): self
    {
        $self = clone $this;
        $self['enrichProfiles'] = $enrichProfiles;

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
