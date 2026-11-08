<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Users;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Returns the creators the selected user subscribes to, in X's order. An account that hides its subscriptions returns an empty list.
 *
 * @see XTwitterScraper\Services\X\UsersService::retrieveSubscriptions()
 *
 * @phpstan-type UserRetrieveSubscriptionsParamsShape = array{
 *   cursor?: string|null,
 *   pageSize?: int|null,
 *   minFollowers?: int|null,
 *   maxFollowers?: int|null,
 *   minFollowing?: int|null,
 *   maxFollowing?: int|null,
 *   minStatuses?: int|null,
 *   maxStatuses?: int|null,
 *   minAccountAgeDays?: int|null,
 *   verifiedOnly?: bool|null,
 *   blueVerifiedOnly?: bool|null,
 *   verifiedType?: string|null,
 *   hasWebsite?: bool|null,
 *   hasLocation?: bool|null,
 *   hasEmail?: bool|null,
 *   businessEmailOnly?: bool|null,
 *   emailDomains?: string|null,
 *   bioContains?: string|null,
 *   locationContains?: string|null,
 *   usernameContains?: string|null,
 *   fields?: string|null,
 *   omit?: string|null,
 * }
 */
final class UserRetrieveSubscriptionsParams implements BaseModel
{
    /** @use SdkModel<UserRetrieveSubscriptionsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Profiles to request from this page (1-200, default 200). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     */
    #[Optional]
    public ?int $pageSize;

    /**
     * Minimum follower count. Profiles the filter drops cost nothing.
     */
    #[Optional]
    public ?int $minFollowers;

    /**
     * Maximum follower count. A profile without a count passes.
     */
    #[Optional]
    public ?int $maxFollowers;

    /**
     * Profiles must follow at least this many accounts.
     */
    #[Optional]
    public ?int $minFollowing;

    /**
     * Profiles may follow at most this many accounts.
     */
    #[Optional]
    public ?int $maxFollowing;

    /**
     * Minimum post count. minPosts is also accepted.
     */
    #[Optional]
    public ?int $minStatuses;

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
     * Only return verified profiles.
     */
    #[Optional]
    public ?bool $verifiedOnly;

    /**
     * Only return profiles X marks as blue verified. X marks many business & government accounts blue too. Use verifiedType for 1 badge type.
     */
    #[Optional]
    public ?bool $blueVerifiedOnly;

    /**
     * Match the verification type exactly, ignoring case.
     */
    #[Optional]
    public ?string $verifiedType;

    /**
     * Only return profiles with a website.
     */
    #[Optional]
    public ?bool $hasWebsite;

    /**
     * Only return profiles with a location.
     */
    #[Optional]
    public ?bool $hasLocation;

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
     * Match any comma-separated or line-separated bio term, ignoring case.
     */
    #[Optional]
    public ?string $bioContains;

    /**
     * Match a location substring, ignoring case.
     */
    #[Optional]
    public ?string $locationContains;

    /**
     * Match a username substring, ignoring case.
     */
    #[Optional]
    public ?string $usernameContains;

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
    public static function with(?string $cursor = null, ?int $pageSize = null, ?int $minFollowers = null, ?int $maxFollowers = null, ?int $minFollowing = null, ?int $maxFollowing = null, ?int $minStatuses = null, ?int $maxStatuses = null, ?int $minAccountAgeDays = null, ?bool $verifiedOnly = null, ?bool $blueVerifiedOnly = null, ?string $verifiedType = null, ?bool $hasWebsite = null, ?bool $hasLocation = null, ?bool $hasEmail = null, ?bool $businessEmailOnly = null, ?string $emailDomains = null, ?string $bioContains = null, ?string $locationContains = null, ?string $usernameContains = null, ?string $fields = null, ?string $omit = null): self
    {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $pageSize && $self['pageSize'] = $pageSize;
        null !== $minFollowers && $self['minFollowers'] = $minFollowers;
        null !== $maxFollowers && $self['maxFollowers'] = $maxFollowers;
        null !== $minFollowing && $self['minFollowing'] = $minFollowing;
        null !== $maxFollowing && $self['maxFollowing'] = $maxFollowing;
        null !== $minStatuses && $self['minStatuses'] = $minStatuses;
        null !== $maxStatuses && $self['maxStatuses'] = $maxStatuses;
        null !== $minAccountAgeDays && $self['minAccountAgeDays'] = $minAccountAgeDays;
        null !== $verifiedOnly && $self['verifiedOnly'] = $verifiedOnly;
        null !== $blueVerifiedOnly && $self['blueVerifiedOnly'] = $blueVerifiedOnly;
        null !== $verifiedType && $self['verifiedType'] = $verifiedType;
        null !== $hasWebsite && $self['hasWebsite'] = $hasWebsite;
        null !== $hasLocation && $self['hasLocation'] = $hasLocation;
        null !== $hasEmail && $self['hasEmail'] = $hasEmail;
        null !== $businessEmailOnly && $self['businessEmailOnly'] = $businessEmailOnly;
        null !== $emailDomains && $self['emailDomains'] = $emailDomains;
        null !== $bioContains && $self['bioContains'] = $bioContains;
        null !== $locationContains && $self['locationContains'] = $locationContains;
        null !== $usernameContains && $self['usernameContains'] = $usernameContains;
        null !== $fields && $self['fields'] = $fields;
        null !== $omit && $self['omit'] = $omit;

        return $self;
    }

    /**
     * Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     */
    public function withCursor(?string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Profiles to request from this page (1-200, default 200). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     */
    public function withPageSize(?int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

        return $self;
    }

    /**
     * Minimum follower count. Profiles the filter drops cost nothing.
     */
    public function withMinFollowers(?int $minFollowers): self
    {
        $self = clone $this;
        $self['minFollowers'] = $minFollowers;

        return $self;
    }

    /**
     * Maximum follower count. A profile without a count passes.
     */
    public function withMaxFollowers(?int $maxFollowers): self
    {
        $self = clone $this;
        $self['maxFollowers'] = $maxFollowers;

        return $self;
    }

    /**
     * Profiles must follow at least this many accounts.
     */
    public function withMinFollowing(?int $minFollowing): self
    {
        $self = clone $this;
        $self['minFollowing'] = $minFollowing;

        return $self;
    }

    /**
     * Profiles may follow at most this many accounts.
     */
    public function withMaxFollowing(?int $maxFollowing): self
    {
        $self = clone $this;
        $self['maxFollowing'] = $maxFollowing;

        return $self;
    }

    /**
     * Minimum post count. minPosts is also accepted.
     */
    public function withMinStatuses(?int $minStatuses): self
    {
        $self = clone $this;
        $self['minStatuses'] = $minStatuses;

        return $self;
    }

    /**
     * Maximum post count. maxPosts is also accepted.
     */
    public function withMaxStatuses(?int $maxStatuses): self
    {
        $self = clone $this;
        $self['maxStatuses'] = $maxStatuses;

        return $self;
    }

    /**
     * Minimum account age in whole days.
     */
    public function withMinAccountAgeDays(?int $minAccountAgeDays): self
    {
        $self = clone $this;
        $self['minAccountAgeDays'] = $minAccountAgeDays;

        return $self;
    }

    /**
     * Only return verified profiles.
     */
    public function withVerifiedOnly(?bool $verifiedOnly): self
    {
        $self = clone $this;
        $self['verifiedOnly'] = $verifiedOnly;

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
     * Match the verification type exactly, ignoring case.
     */
    public function withVerifiedType(?string $verifiedType): self
    {
        $self = clone $this;
        $self['verifiedType'] = $verifiedType;

        return $self;
    }

    /**
     * Only return profiles with a website.
     */
    public function withHasWebsite(?bool $hasWebsite): self
    {
        $self = clone $this;
        $self['hasWebsite'] = $hasWebsite;

        return $self;
    }

    /**
     * Only return profiles with a location.
     */
    public function withHasLocation(?bool $hasLocation): self
    {
        $self = clone $this;
        $self['hasLocation'] = $hasLocation;

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
     * Match any comma-separated or line-separated bio term, ignoring case.
     */
    public function withBioContains(?string $bioContains): self
    {
        $self = clone $this;
        $self['bioContains'] = $bioContains;

        return $self;
    }

    /**
     * Match a location substring, ignoring case.
     */
    public function withLocationContains(?string $locationContains): self
    {
        $self = clone $this;
        $self['locationContains'] = $locationContains;

        return $self;
    }

    /**
     * Match a username substring, ignoring case.
     */
    public function withUsernameContains(?string $usernameContains): self
    {
        $self = clone $this;
        $self['usernameContains'] = $usernameContains;

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
