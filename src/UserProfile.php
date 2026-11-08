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
use XTwitterScraper\UserProfile\AffiliatesHighlightedLabel;
use XTwitterScraper\UserProfile\Birthdate;
use XTwitterScraper\UserProfile\HighlightsInfo;
use XTwitterScraper\UserProfile\IdentityVerification;
use XTwitterScraper\UserProfile\UsernameChanges;
use XTwitterScraper\UserProfile\VerificationReason;

/**
 * X user profile with bio, follower counts, and verification status.
 *
 * @phpstan-import-type AffiliatesHighlightedLabelShape from AffiliatesHighlightedLabel
 * @phpstan-import-type HighlightsInfoShape from HighlightsInfo
 * @phpstan-import-type IdentityVerificationShape from IdentityVerification
 *
 * @phpstan-type UserProfileShape = array{
 *   id: string,
 *   name: string,
 *   username: string,
 *   affiliatesHighlightedLabel?: null|AffiliatesHighlightedLabel|AffiliatesHighlightedLabelShape,
 *   automatedBy?: string|null,
 *   businessAccountAffiliatesCount?: int|null,
 *   communityRole?: string|null,
 *   coverPicture?: string|null,
 *   createdAt?: string|null,
 *   creatorSubscriptionsCount?: int|null,
 *   description?: string|null,
 *   favouritesCount?: int|null,
 *   followers?: int|null,
 *   following?: int|null,
 *   hasCustomTimelines?: bool|null,
 *   hasGraduatedAccess?: bool|null,
 *   hasHiddenSubscriptionsOnProfile?: bool|null,
 *   highlightsInfo?: null|HighlightsInfo|HighlightsInfoShape,
 *   identityVerification?: null|IdentityVerification|IdentityVerificationShape,
 *   isAutomated?: bool|null,
 *   isBlueVerified?: bool|null,
 *   isProfileTranslatable?: bool|null,
 *   isTranslator?: bool|null,
 *   isVerified?: bool|null,
 *   location?: string|null,
 *   mediaCount?: int|null,
 *   parodyCommentaryFanLabel?: string|null,
 *   pinnedTweetIDs?: list<string>|null,
 *   possiblySensitive?: bool|null,
 *   profileBio?: array<string,mixed>|null,
 *   profileBannerURL?: string|null,
 *   profileDescriptionLanguage?: string|null,
 *   profileImageShape?: string|null,
 *   profileInterstitialType?: string|null,
 *   profilePicture?: string|null,
 *   profileSortEnabled?: bool|null,
 *   profileTranslatorType?: string|null,
 *   protected?: bool|null,
 *   statusesCount?: int|null,
 *   superFollowEligible?: bool|null,
 *   unavailable?: bool|null,
 *   unavailableReason?: string|null,
 *   url?: string|null,
 *   verified?: bool|null,
 *   verifiedType?: string|null,
 *   withheldInCountries?: list<string>|null,
 *   profilePictureOriginal?: string|null,
 *   accountBasedIn?: AccountBasedIn|array<string,mixed>|null,
 *   accountBasedInUnavailable?: bool|null,
 *   accountBasedInAccurate?: bool|null,
 *   connectedVia?: string|null,
 *   connectedViaAccurate?: bool|null,
 *   affiliateUsername?: string|null,
 *   email?: string|null,
 *   contactInfo?: ProfileContactInfo|array<string,mixed>|null,
 *   usernameChanges?: UsernameChanges|array<string,mixed>|null,
 *   birthdate?: Birthdate|array<string,mixed>|null,
 *   retweetedAt?: \DateTimeInterface|null,
 *   withheldScope?: string|null,
 *   professional?: array<string,mixed>|null,
 *   grokTranslatedBio?: array<string,mixed>|null,
 *   redirectsToUsername?: string|null,
 *   superFollowsUserProfileActive?: bool|null,
 *   tipJar?: UserTipJar|array<string,mixed>|null,
 *   listedCount?: int|null,
 *   fastFollowersCount?: int|null,
 *   normalFollowersCount?: int|null,
 *   defaultProfile?: bool|null,
 *   defaultProfileImage?: bool|null,
 *   hasExtendedProfile?: bool|null,
 *   isTranslationEnabled?: bool|null,
 *   geoEnabled?: bool|null,
 *   advertiserAccountType?: string|null,
 *   advertiserAccountServiceLevels?: list<string>|null,
 *   businessProfileState?: string|null,
 *   subscribersCount?: int|null,
 *   verificationReason?: VerificationReason|array<string,mixed>|null,
 * }
 */
final class UserProfile implements BaseModel
{
    /** @use SdkModel<UserProfileShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $name;

    #[Required]
    public string $username;

    /**
     * Organization affiliation label shown on an X profile.
     */
    #[Optional]
    public ?AffiliatesHighlightedLabel $affiliatesHighlightedLabel;

    #[Optional]
    public ?string $automatedBy;

    #[Optional]
    public ?int $businessAccountAffiliatesCount;

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
    public ?int $creatorSubscriptionsCount;

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
    public ?bool $hasGraduatedAccess;

    #[Optional]
    public ?bool $hasHiddenSubscriptionsOnProfile;

    /**
     * Profile highlight availability and count metadata.
     */
    #[Optional]
    public ?HighlightsInfo $highlightsInfo;

    /**
     * Identity verification metadata displayed by X.
     */
    #[Optional]
    public ?IdentityVerification $identityVerification;

    #[Optional]
    public ?bool $isAutomated;

    /**
     * Whether X shows a blue verification badge.
     */
    #[Optional]
    public ?bool $isBlueVerified;

    #[Optional]
    public ?bool $isProfileTranslatable;

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

    #[Optional]
    public ?string $parodyCommentaryFanLabel;

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
    public ?string $profileDescriptionLanguage;

    #[Optional]
    public ?string $profileImageShape;

    #[Optional]
    public ?string $profileInterstitialType;

    #[Optional]
    public ?string $profilePicture;

    #[Optional]
    public ?bool $profileSortEnabled;

    #[Optional]
    public ?string $profileTranslatorType;

    /**
     * Whether the profile protects its posts.
     */
    #[Optional]
    public ?bool $protected;

    #[Optional]
    public ?int $statusesCount;

    #[Optional]
    public ?bool $superFollowEligible;

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

    /** @var list<string>|null $withheldInCountries */
    #[Optional(list: 'string')]
    public ?array $withheldInCountries;

    /**
     * The same profile picture at full size, as the account uploaded it. Download this one for the image.
     */
    #[Optional]
    public ?string $profilePictureOriginal;

    /**
     * Null when X shows no label.
     */
    #[Optional(nullable: true)]
    public ?AccountBasedIn $accountBasedIn;

    /**
     * True when X withheld accountBasedIn from this read. Retry later.
     */
    #[Optional]
    public ?bool $accountBasedInUnavailable;

    /**
     * False when X notes accountBasedIn may be inaccurate.
     */
    #[Optional]
    public ?bool $accountBasedInAccurate;

    /**
     * How the account first connected to X.
     */
    #[Optional]
    public ?string $connectedVia;

    /**
     * False when X notes that country may be inaccurate.
     */
    #[Optional]
    public ?bool $connectedViaAccurate;

    /**
     * Handle of the organization X shows the account is affiliated with, from its About page.
     */
    #[Optional]
    public ?string $affiliateUsername;

    /**
     * First email the account publishes on its profile, lowercased. Omitted when it publishes none.
     */
    #[Optional]
    public ?string $email;

    /**
     * Emails, phone numbers & links the account publishes on its own profile. Omitted when it publishes none.
     */
    #[Optional]
    public ?ProfileContactInfo $contactInfo;

    /**
     * How often the account changed its username.
     */
    #[Optional]
    public ?UsernameChanges $usernameChanges;

    /**
     * The parts of the birthday the account made public.
     */
    #[Optional]
    public ?Birthdate $birthdate;

    /**
     * UTC repost time with includeRetweetTimestamp. Null when Xquik found no repost time. Otherwise omitted.
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $retweetedAt;

    /**
     * Whether X withholds a post or user.
     */
    #[Optional]
    public ?string $withheldScope;

    /**
     * Professional metadata with category display settings.
     *
     * @var array<string,mixed>|null $professional
     */
    #[Optional(map: 'mixed')]
    public ?array $professional;

    /**
     * Public profile bio translation returned by X.
     *
     * @var array<string,mixed>|null $grokTranslatedBio
     */
    #[Optional(map: 'mixed')]
    public ?array $grokTranslatedBio;

    /**
     * Handle x.com sends this profile's visitors to, such as the new handle of a renamed account whose old handle now holds a placeholder. Missing when x.com shows the profile itself.
     */
    #[Optional]
    public ?string $redirectsToUsername;

    /**
     * Whether X marks the subscription profile as active.
     */
    #[Optional]
    public ?bool $superFollowsUserProfileActive;

    /**
     * Public payment and creator-support handles shown on X.
     */
    #[Optional]
    public ?UserTipJar $tipJar;

    /**
     * Public lists that include the profile.
     */
    #[Optional]
    public ?int $listedCount;

    /**
     * Followers X counts as fast followers.
     */
    #[Optional]
    public ?int $fastFollowersCount;

    /**
     * Followers minus fast followers.
     */
    #[Optional]
    public ?int $normalFollowersCount;

    /**
     * Whether the profile keeps X's default theme.
     */
    #[Optional]
    public ?bool $defaultProfile;

    /**
     * Whether the profile keeps X's default avatar.
     */
    #[Optional]
    public ?bool $defaultProfileImage;

    /**
     * Whether the profile filled X's extended fields, such as a birth date. True or false.
     */
    #[Optional]
    public ?bool $hasExtendedProfile;

    /**
     * Whether the account turned on X's translation of its posts. True or false.
     */
    #[Optional]
    public ?bool $isTranslationEnabled;

    /**
     * Whether the profile may add a location to posts.
     */
    #[Optional]
    public ?bool $geoEnabled;

    /**
     * The account's X Ads type. `none` for an account without ads, or `promotable_user` for one that may run them.
     */
    #[Optional]
    public ?string $advertiserAccountType;

    /**
     * X Ads services the account uses, such as `analytics`, `media_studio` or `smb`. Empty for an account without ads.
     *
     * @var list<string>|null $advertiserAccountServiceLevels
     */
    #[Optional(list: 'string')]
    public ?array $advertiserAccountServiceLevels;

    /**
     * Whether X treats the profile as a business profile. `none` or `enabled`.
     */
    #[Optional]
    public ?string $businessProfileState;

    /**
     * Accounts subscribed to the profile's paid Subscriptions. 0 when it has none.
     */
    #[Optional]
    public ?int $subscribersCount;

    /**
     * X's text on why the profile is verified, with its links.
     */
    #[Optional]
    public ?VerificationReason $verificationReason;

    /**
     * `new UserProfile()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserProfile::with(id: ..., name: ..., username: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserProfile)->withID(...)->withName(...)->withUsername(...)
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
     * @param AffiliatesHighlightedLabel|AffiliatesHighlightedLabelShape|null $affiliatesHighlightedLabel
     * @param HighlightsInfo|HighlightsInfoShape|null $highlightsInfo
     * @param IdentityVerification|IdentityVerificationShape|null $identityVerification
     * @param list<string>|null $pinnedTweetIDs
     * @param array<string,mixed>|null $profileBio
     * @param list<string>|null $withheldInCountries
     * @param AccountBasedIn|array<string,mixed>|null $accountBasedIn
     * @param ProfileContactInfo|array<string,mixed>|null $contactInfo
     * @param UsernameChanges|array<string,mixed>|null $usernameChanges
     * @param Birthdate|array<string,mixed>|null $birthdate
     * @param array<string,mixed>|null $professional
     * @param array<string,mixed>|null $grokTranslatedBio
     * @param UserTipJar|array<string,mixed>|null $tipJar
     * @param list<string>|null $advertiserAccountServiceLevels
     * @param VerificationReason|array<string,mixed>|null $verificationReason
     */
    public static function with(
        string $id,
        string $name,
        string $username,
        AffiliatesHighlightedLabel|array|null $affiliatesHighlightedLabel = null,
        ?string $automatedBy = null,
        ?int $businessAccountAffiliatesCount = null,
        ?string $communityRole = null,
        ?string $coverPicture = null,
        ?string $createdAt = null,
        ?int $creatorSubscriptionsCount = null,
        ?string $description = null,
        ?int $favouritesCount = null,
        ?int $followers = null,
        ?int $following = null,
        ?bool $hasCustomTimelines = null,
        ?bool $hasGraduatedAccess = null,
        ?bool $hasHiddenSubscriptionsOnProfile = null,
        HighlightsInfo|array|null $highlightsInfo = null,
        IdentityVerification|array|null $identityVerification = null,
        ?bool $isAutomated = null,
        ?bool $isBlueVerified = null,
        ?bool $isProfileTranslatable = null,
        ?bool $isTranslator = null,
        ?bool $isVerified = null,
        ?string $location = null,
        ?int $mediaCount = null,
        ?string $parodyCommentaryFanLabel = null,
        ?array $pinnedTweetIDs = null,
        ?bool $possiblySensitive = null,
        ?array $profileBio = null,
        ?string $profileBannerURL = null,
        ?string $profileDescriptionLanguage = null,
        ?string $profileImageShape = null,
        ?string $profileInterstitialType = null,
        ?string $profilePicture = null,
        ?bool $profileSortEnabled = null,
        ?string $profileTranslatorType = null,
        ?bool $protected = null,
        ?int $statusesCount = null,
        ?bool $superFollowEligible = null,
        ?bool $unavailable = null,
        ?string $unavailableReason = null,
        ?string $url = null,
        ?bool $verified = null,
        ?string $verifiedType = null,
        ?array $withheldInCountries = null,
        ?string $profilePictureOriginal = null,
        AccountBasedIn|array|null $accountBasedIn = null,
        ?bool $accountBasedInUnavailable = null,
        ?bool $accountBasedInAccurate = null,
        ?string $connectedVia = null,
        ?bool $connectedViaAccurate = null,
        ?string $affiliateUsername = null,
        ?string $email = null,
        ProfileContactInfo|array|null $contactInfo = null,
        UsernameChanges|array|null $usernameChanges = null,
        Birthdate|array|null $birthdate = null,
        ?\DateTimeInterface $retweetedAt = null,
        ?string $withheldScope = null,
        ?array $professional = null,
        ?array $grokTranslatedBio = null,
        ?string $redirectsToUsername = null,
        ?bool $superFollowsUserProfileActive = null,
        UserTipJar|array|null $tipJar = null,
        ?int $listedCount = null,
        ?int $fastFollowersCount = null,
        ?int $normalFollowersCount = null,
        ?bool $defaultProfile = null,
        ?bool $defaultProfileImage = null,
        ?bool $hasExtendedProfile = null,
        ?bool $isTranslationEnabled = null,
        ?bool $geoEnabled = null,
        ?string $advertiserAccountType = null,
        ?array $advertiserAccountServiceLevels = null,
        ?string $businessProfileState = null,
        ?int $subscribersCount = null,
        VerificationReason|array|null $verificationReason = null
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['name'] = $name;
        $self['username'] = $username;

        null !== $affiliatesHighlightedLabel && $self['affiliatesHighlightedLabel'] = $affiliatesHighlightedLabel;
        null !== $automatedBy && $self['automatedBy'] = $automatedBy;
        null !== $businessAccountAffiliatesCount && $self['businessAccountAffiliatesCount'] = $businessAccountAffiliatesCount;
        null !== $communityRole && $self['communityRole'] = $communityRole;
        null !== $coverPicture && $self['coverPicture'] = $coverPicture;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $creatorSubscriptionsCount && $self['creatorSubscriptionsCount'] = $creatorSubscriptionsCount;
        null !== $description && $self['description'] = $description;
        null !== $favouritesCount && $self['favouritesCount'] = $favouritesCount;
        null !== $followers && $self['followers'] = $followers;
        null !== $following && $self['following'] = $following;
        null !== $hasCustomTimelines && $self['hasCustomTimelines'] = $hasCustomTimelines;
        null !== $hasGraduatedAccess && $self['hasGraduatedAccess'] = $hasGraduatedAccess;
        null !== $hasHiddenSubscriptionsOnProfile && $self['hasHiddenSubscriptionsOnProfile'] = $hasHiddenSubscriptionsOnProfile;
        null !== $highlightsInfo && $self['highlightsInfo'] = $highlightsInfo;
        null !== $identityVerification && $self['identityVerification'] = $identityVerification;
        null !== $isAutomated && $self['isAutomated'] = $isAutomated;
        null !== $isBlueVerified && $self['isBlueVerified'] = $isBlueVerified;
        null !== $isProfileTranslatable && $self['isProfileTranslatable'] = $isProfileTranslatable;
        null !== $isTranslator && $self['isTranslator'] = $isTranslator;
        null !== $isVerified && $self['isVerified'] = $isVerified;
        null !== $location && $self['location'] = $location;
        null !== $mediaCount && $self['mediaCount'] = $mediaCount;
        null !== $parodyCommentaryFanLabel && $self['parodyCommentaryFanLabel'] = $parodyCommentaryFanLabel;
        null !== $pinnedTweetIDs && $self['pinnedTweetIDs'] = $pinnedTweetIDs;
        null !== $possiblySensitive && $self['possiblySensitive'] = $possiblySensitive;
        null !== $profileBio && $self['profileBio'] = $profileBio;
        null !== $profileBannerURL && $self['profileBannerURL'] = $profileBannerURL;
        null !== $profileDescriptionLanguage && $self['profileDescriptionLanguage'] = $profileDescriptionLanguage;
        null !== $profileImageShape && $self['profileImageShape'] = $profileImageShape;
        null !== $profileInterstitialType && $self['profileInterstitialType'] = $profileInterstitialType;
        null !== $profilePicture && $self['profilePicture'] = $profilePicture;
        null !== $profileSortEnabled && $self['profileSortEnabled'] = $profileSortEnabled;
        null !== $profileTranslatorType && $self['profileTranslatorType'] = $profileTranslatorType;
        null !== $protected && $self['protected'] = $protected;
        null !== $statusesCount && $self['statusesCount'] = $statusesCount;
        null !== $superFollowEligible && $self['superFollowEligible'] = $superFollowEligible;
        null !== $unavailable && $self['unavailable'] = $unavailable;
        null !== $unavailableReason && $self['unavailableReason'] = $unavailableReason;
        null !== $url && $self['url'] = $url;
        null !== $verified && $self['verified'] = $verified;
        null !== $verifiedType && $self['verifiedType'] = $verifiedType;
        null !== $withheldInCountries && $self['withheldInCountries'] = $withheldInCountries;

        null !== $profilePictureOriginal && $self['profilePictureOriginal'] = $profilePictureOriginal;

        null !== $accountBasedIn && $self['accountBasedIn'] = $accountBasedIn;

        null !== $accountBasedInUnavailable && $self['accountBasedInUnavailable'] = $accountBasedInUnavailable;

        null !== $accountBasedInAccurate && $self['accountBasedInAccurate'] = $accountBasedInAccurate;

        null !== $connectedVia && $self['connectedVia'] = $connectedVia;

        null !== $connectedViaAccurate && $self['connectedViaAccurate'] = $connectedViaAccurate;

        null !== $affiliateUsername && $self['affiliateUsername'] = $affiliateUsername;

        null !== $email && $self['email'] = $email;

        null !== $contactInfo && $self['contactInfo'] = $contactInfo;

        null !== $usernameChanges && $self['usernameChanges'] = $usernameChanges;

        null !== $birthdate && $self['birthdate'] = $birthdate;

        null !== $retweetedAt && $self['retweetedAt'] = $retweetedAt;

        null !== $withheldScope && $self['withheldScope'] = $withheldScope;

        null !== $professional && $self['professional'] = $professional;

        null !== $grokTranslatedBio && $self['grokTranslatedBio'] = $grokTranslatedBio;

        null !== $redirectsToUsername && $self['redirectsToUsername'] = $redirectsToUsername;

        null !== $superFollowsUserProfileActive && $self['superFollowsUserProfileActive'] = $superFollowsUserProfileActive;

        null !== $tipJar && $self['tipJar'] = $tipJar;

        null !== $listedCount && $self['listedCount'] = $listedCount;

        null !== $fastFollowersCount && $self['fastFollowersCount'] = $fastFollowersCount;

        null !== $normalFollowersCount && $self['normalFollowersCount'] = $normalFollowersCount;

        null !== $defaultProfile && $self['defaultProfile'] = $defaultProfile;

        null !== $defaultProfileImage && $self['defaultProfileImage'] = $defaultProfileImage;

        null !== $hasExtendedProfile && $self['hasExtendedProfile'] = $hasExtendedProfile;

        null !== $isTranslationEnabled && $self['isTranslationEnabled'] = $isTranslationEnabled;

        null !== $geoEnabled && $self['geoEnabled'] = $geoEnabled;

        null !== $advertiserAccountType && $self['advertiserAccountType'] = $advertiserAccountType;

        null !== $advertiserAccountServiceLevels && $self['advertiserAccountServiceLevels'] = $advertiserAccountServiceLevels;

        null !== $businessProfileState && $self['businessProfileState'] = $businessProfileState;

        null !== $subscribersCount && $self['subscribersCount'] = $subscribersCount;

        null !== $verificationReason && $self['verificationReason'] = $verificationReason;

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

    /**
     * Organization affiliation label shown on an X profile.
     *
     * @param AffiliatesHighlightedLabel|AffiliatesHighlightedLabelShape $affiliatesHighlightedLabel
     */
    public function withAffiliatesHighlightedLabel(
        AffiliatesHighlightedLabel|array $affiliatesHighlightedLabel
    ): self {
        $self = clone $this;
        $self['affiliatesHighlightedLabel'] = $affiliatesHighlightedLabel;

        return $self;
    }

    public function withAutomatedBy(string $automatedBy): self
    {
        $self = clone $this;
        $self['automatedBy'] = $automatedBy;

        return $self;
    }

    public function withBusinessAccountAffiliatesCount(
        int $businessAccountAffiliatesCount
    ): self {
        $self = clone $this;
        $self['businessAccountAffiliatesCount'] = $businessAccountAffiliatesCount;

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

    public function withCreatorSubscriptionsCount(
        int $creatorSubscriptionsCount
    ): self {
        $self = clone $this;
        $self['creatorSubscriptionsCount'] = $creatorSubscriptionsCount;

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

    public function withHasGraduatedAccess(bool $hasGraduatedAccess): self
    {
        $self = clone $this;
        $self['hasGraduatedAccess'] = $hasGraduatedAccess;

        return $self;
    }

    public function withHasHiddenSubscriptionsOnProfile(
        bool $hasHiddenSubscriptionsOnProfile
    ): self {
        $self = clone $this;
        $self['hasHiddenSubscriptionsOnProfile'] = $hasHiddenSubscriptionsOnProfile;

        return $self;
    }

    /**
     * Profile highlight availability and count metadata.
     *
     * @param HighlightsInfo|HighlightsInfoShape $highlightsInfo
     */
    public function withHighlightsInfo(
        HighlightsInfo|array $highlightsInfo
    ): self {
        $self = clone $this;
        $self['highlightsInfo'] = $highlightsInfo;

        return $self;
    }

    /**
     * Identity verification metadata displayed by X.
     *
     * @param IdentityVerification|IdentityVerificationShape $identityVerification
     */
    public function withIdentityVerification(
        IdentityVerification|array $identityVerification
    ): self {
        $self = clone $this;
        $self['identityVerification'] = $identityVerification;

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

    public function withIsProfileTranslatable(bool $isProfileTranslatable): self
    {
        $self = clone $this;
        $self['isProfileTranslatable'] = $isProfileTranslatable;

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

    public function withParodyCommentaryFanLabel(
        string $parodyCommentaryFanLabel
    ): self {
        $self = clone $this;
        $self['parodyCommentaryFanLabel'] = $parodyCommentaryFanLabel;

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

    public function withProfileDescriptionLanguage(
        string $profileDescriptionLanguage
    ): self {
        $self = clone $this;
        $self['profileDescriptionLanguage'] = $profileDescriptionLanguage;

        return $self;
    }

    public function withProfileImageShape(string $profileImageShape): self
    {
        $self = clone $this;
        $self['profileImageShape'] = $profileImageShape;

        return $self;
    }

    public function withProfileInterstitialType(
        string $profileInterstitialType
    ): self {
        $self = clone $this;
        $self['profileInterstitialType'] = $profileInterstitialType;

        return $self;
    }

    public function withProfilePicture(string $profilePicture): self
    {
        $self = clone $this;
        $self['profilePicture'] = $profilePicture;

        return $self;
    }

    public function withProfileSortEnabled(bool $profileSortEnabled): self
    {
        $self = clone $this;
        $self['profileSortEnabled'] = $profileSortEnabled;

        return $self;
    }

    public function withProfileTranslatorType(
        string $profileTranslatorType
    ): self {
        $self = clone $this;
        $self['profileTranslatorType'] = $profileTranslatorType;

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

    public function withSuperFollowEligible(bool $superFollowEligible): self
    {
        $self = clone $this;
        $self['superFollowEligible'] = $superFollowEligible;

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
     * @param list<string> $withheldInCountries
     */
    public function withWithheldInCountries(array $withheldInCountries): self
    {
        $self = clone $this;
        $self['withheldInCountries'] = $withheldInCountries;

        return $self;
    }

    /**
     * The same profile picture at full size, as the account uploaded it. Download this one for the image.
     */
    public function withProfilePictureOriginal(?string $profilePictureOriginal): self
    {
        $self = clone $this;
        $self['profilePictureOriginal'] = $profilePictureOriginal;

        return $self;
    }

    /**
     * Null when X shows no label.
     *
     * @param AccountBasedIn|array<string,mixed>|null $accountBasedIn
     */
    public function withAccountBasedIn(AccountBasedIn|array|null $accountBasedIn): self
    {
        $self = clone $this;
        $self['accountBasedIn'] = $accountBasedIn;

        return $self;
    }

    /**
     * True when X withheld accountBasedIn from this read. Retry later.
     */
    public function withAccountBasedInUnavailable(?bool $accountBasedInUnavailable): self
    {
        $self = clone $this;
        $self['accountBasedInUnavailable'] = $accountBasedInUnavailable;

        return $self;
    }

    /**
     * False when X notes accountBasedIn may be inaccurate.
     */
    public function withAccountBasedInAccurate(?bool $accountBasedInAccurate): self
    {
        $self = clone $this;
        $self['accountBasedInAccurate'] = $accountBasedInAccurate;

        return $self;
    }

    /**
     * How the account first connected to X.
     */
    public function withConnectedVia(?string $connectedVia): self
    {
        $self = clone $this;
        $self['connectedVia'] = $connectedVia;

        return $self;
    }

    /**
     * False when X notes that country may be inaccurate.
     */
    public function withConnectedViaAccurate(?bool $connectedViaAccurate): self
    {
        $self = clone $this;
        $self['connectedViaAccurate'] = $connectedViaAccurate;

        return $self;
    }

    /**
     * Handle of the organization X shows the account is affiliated with, from its About page.
     */
    public function withAffiliateUsername(?string $affiliateUsername): self
    {
        $self = clone $this;
        $self['affiliateUsername'] = $affiliateUsername;

        return $self;
    }

    /**
     * First email the account publishes on its profile, lowercased. Omitted when it publishes none.
     */
    public function withEmail(?string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    /**
     * Emails, phone numbers & links the account publishes on its own profile. Omitted when it publishes none.
     *
     * @param ProfileContactInfo|array<string,mixed>|null $contactInfo
     */
    public function withContactInfo(ProfileContactInfo|array|null $contactInfo): self
    {
        $self = clone $this;
        $self['contactInfo'] = $contactInfo;

        return $self;
    }

    /**
     * How often the account changed its username.
     *
     * @param UsernameChanges|array<string,mixed>|null $usernameChanges
     */
    public function withUsernameChanges(UsernameChanges|array|null $usernameChanges): self
    {
        $self = clone $this;
        $self['usernameChanges'] = $usernameChanges;

        return $self;
    }

    /**
     * The parts of the birthday the account made public.
     *
     * @param Birthdate|array<string,mixed>|null $birthdate
     */
    public function withBirthdate(Birthdate|array|null $birthdate): self
    {
        $self = clone $this;
        $self['birthdate'] = $birthdate;

        return $self;
    }

    /**
     * UTC repost time with includeRetweetTimestamp. Null when Xquik found no repost time. Otherwise omitted.
     */
    public function withRetweetedAt(?\DateTimeInterface $retweetedAt): self
    {
        $self = clone $this;
        $self['retweetedAt'] = $retweetedAt;

        return $self;
    }

    /**
     * Whether X withholds a post or user.
     */
    public function withWithheldScope(?string $withheldScope): self
    {
        $self = clone $this;
        $self['withheldScope'] = $withheldScope;

        return $self;
    }

    /**
     * Professional metadata with category display settings.
     *
     * @param array<string,mixed>|null $professional
     */
    public function withProfessional(?array $professional): self
    {
        $self = clone $this;
        $self['professional'] = $professional;

        return $self;
    }

    /**
     * Public profile bio translation returned by X.
     *
     * @param array<string,mixed>|null $grokTranslatedBio
     */
    public function withGrokTranslatedBio(?array $grokTranslatedBio): self
    {
        $self = clone $this;
        $self['grokTranslatedBio'] = $grokTranslatedBio;

        return $self;
    }

    /**
     * Handle x.com sends this profile's visitors to, such as the new handle of a renamed account whose old handle now holds a placeholder. Missing when x.com shows the profile itself.
     */
    public function withRedirectsToUsername(?string $redirectsToUsername): self
    {
        $self = clone $this;
        $self['redirectsToUsername'] = $redirectsToUsername;

        return $self;
    }

    /**
     * Whether X marks the subscription profile as active.
     */
    public function withSuperFollowsUserProfileActive(?bool $superFollowsUserProfileActive): self
    {
        $self = clone $this;
        $self['superFollowsUserProfileActive'] = $superFollowsUserProfileActive;

        return $self;
    }

    /**
     * Public payment and creator-support handles shown on X.
     *
     * @param UserTipJar|array<string,mixed>|null $tipJar
     */
    public function withTipJar(UserTipJar|array|null $tipJar): self
    {
        $self = clone $this;
        $self['tipJar'] = $tipJar;

        return $self;
    }

    /**
     * Public lists that include the profile.
     */
    public function withListedCount(?int $listedCount): self
    {
        $self = clone $this;
        $self['listedCount'] = $listedCount;

        return $self;
    }

    /**
     * Followers X counts as fast followers.
     */
    public function withFastFollowersCount(?int $fastFollowersCount): self
    {
        $self = clone $this;
        $self['fastFollowersCount'] = $fastFollowersCount;

        return $self;
    }

    /**
     * Followers minus fast followers.
     */
    public function withNormalFollowersCount(?int $normalFollowersCount): self
    {
        $self = clone $this;
        $self['normalFollowersCount'] = $normalFollowersCount;

        return $self;
    }

    /**
     * Whether the profile keeps X's default theme.
     */
    public function withDefaultProfile(?bool $defaultProfile): self
    {
        $self = clone $this;
        $self['defaultProfile'] = $defaultProfile;

        return $self;
    }

    /**
     * Whether the profile keeps X's default avatar.
     */
    public function withDefaultProfileImage(?bool $defaultProfileImage): self
    {
        $self = clone $this;
        $self['defaultProfileImage'] = $defaultProfileImage;

        return $self;
    }

    /**
     * Whether the profile filled X's extended fields, such as a birth date. True or false.
     */
    public function withHasExtendedProfile(?bool $hasExtendedProfile): self
    {
        $self = clone $this;
        $self['hasExtendedProfile'] = $hasExtendedProfile;

        return $self;
    }

    /**
     * Whether the account turned on X's translation of its posts. True or false.
     */
    public function withIsTranslationEnabled(?bool $isTranslationEnabled): self
    {
        $self = clone $this;
        $self['isTranslationEnabled'] = $isTranslationEnabled;

        return $self;
    }

    /**
     * Whether the profile may add a location to posts.
     */
    public function withGeoEnabled(?bool $geoEnabled): self
    {
        $self = clone $this;
        $self['geoEnabled'] = $geoEnabled;

        return $self;
    }

    /**
     * The account's X Ads type. `none` for an account without ads, or `promotable_user` for one that may run them.
     */
    public function withAdvertiserAccountType(?string $advertiserAccountType): self
    {
        $self = clone $this;
        $self['advertiserAccountType'] = $advertiserAccountType;

        return $self;
    }

    /**
     * X Ads services the account uses, such as `analytics`, `media_studio` or `smb`. Empty for an account without ads.
     *
     * @param list<string>|null $advertiserAccountServiceLevels
     */
    public function withAdvertiserAccountServiceLevels(?array $advertiserAccountServiceLevels): self
    {
        $self = clone $this;
        $self['advertiserAccountServiceLevels'] = $advertiserAccountServiceLevels;

        return $self;
    }

    /**
     * Whether X treats the profile as a business profile. `none` or `enabled`.
     */
    public function withBusinessProfileState(?string $businessProfileState): self
    {
        $self = clone $this;
        $self['businessProfileState'] = $businessProfileState;

        return $self;
    }

    /**
     * Accounts subscribed to the profile's paid Subscriptions. 0 when it has none.
     */
    public function withSubscribersCount(?int $subscribersCount): self
    {
        $self = clone $this;
        $self['subscribersCount'] = $subscribersCount;

        return $self;
    }

    /**
     * X's text on why the profile is verified, with its links.
     *
     * @param VerificationReason|array<string,mixed>|null $verificationReason
     */
    public function withVerificationReason(VerificationReason|array|null $verificationReason): self
    {
        $self = clone $this;
        $self['verificationReason'] = $verificationReason;

        return $self;
    }
}
