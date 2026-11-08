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
 * Look up multiple users by IDs in one call.
 *
 * @see XTwitterScraper\Services\X\UsersService::retrieveBatch()
 *
 * @phpstan-type UserRetrieveBatchParamsShape = array{ids: string,
 *   usernames?: string|null,
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
final class UserRetrieveBatchParams implements BaseModel
{
    /** @use SdkModel<UserRetrieveBatchParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Comma-separated numeric user IDs (1-100 values). Duplicate IDs are ignored while preserving first-seen order.
     */
    #[Required]
    public string $ids;

    /**
     * Comma-separated X usernames, with or without @, or profile links such as x.com/nasa (1-100 values), in place of ids. A name in another case is the same account. A longer URL fails at the edge before Xquik reads it.
     */
    #[Optional]
    public ?string $usernames;

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

    /**
     * `new UserRetrieveBatchParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserRetrieveBatchParams::with(ids: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserRetrieveBatchParams)->withIDs(...)
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
    public static function with(string $ids, ?string $usernames = null, ?int $minFollowers = null, ?int $maxFollowers = null, ?int $minFollowing = null, ?int $maxFollowing = null, ?int $minStatuses = null, ?int $maxStatuses = null, ?int $minAccountAgeDays = null, ?bool $verifiedOnly = null, ?bool $blueVerifiedOnly = null, ?string $verifiedType = null, ?bool $hasWebsite = null, ?bool $hasLocation = null, ?bool $hasEmail = null, ?bool $businessEmailOnly = null, ?string $emailDomains = null, ?string $bioContains = null, ?string $locationContains = null, ?string $usernameContains = null, ?string $fields = null, ?string $omit = null): self
    {
        $self = new self;

        $self['ids'] = $ids;

        null !== $usernames && $self['usernames'] = $usernames;

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
     * Comma-separated numeric user IDs (1-100 values). Duplicate IDs are ignored while preserving first-seen order.
     */
    public function withIDs(string $ids): self
    {
        $self = clone $this;
        $self['ids'] = $ids;

        return $self;
    }

    /**
     * Comma-separated X usernames, with or without @, or profile links such as x.com/nasa (1-100 values), in place of ids. A name in another case is the same account. A longer URL fails at the edge before Xquik reads it.
     */
    public function withUsernames(?string $usernames): self
    {
        $self = clone $this;
        $self['usernames'] = $usernames;

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
