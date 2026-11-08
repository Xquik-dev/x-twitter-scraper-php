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

/**
 * @phpstan-type SpaceParticipantShape = array{
 *   id: string,
 *   username: string,
 *   name: string,
 *   profilePicture?: string|null,
 *   profilePictureOriginal?: string|null,
 *   isVerified?: bool|null,
 *   isBlueVerified?: bool|null,
 *   verifiedType?: string|null,
 *   affiliatesHighlightedLabel?: UserAffiliateLabel|array<string,mixed>|null,
 *   joinedAt?: \DateTimeInterface|null,
 *   isMutedByAdmin?: bool|null,
 *   isMutedByGuest?: bool|null,
 *   periscopeUserID?: string|null,
 * }
 */
final class SpaceParticipant implements BaseModel
{
    /** @use SdkModel<SpaceParticipantShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $username;

    /**
     * Name the account shows in the Space.
     */
    #[Required]
    public string $name;

    /**
     * Profile picture URL.
     */
    #[Optional]
    public ?string $profilePicture;

    /**
     * The participant's profile picture at full size.
     */
    #[Optional]
    public ?string $profilePictureOriginal;

    /**
     * Whether X shows a verified badge in the Space.
     */
    #[Optional]
    public ?bool $isVerified;

    /**
     * Whether the account has X Premium verification.
     */
    #[Optional]
    public ?bool $isBlueVerified;

    /**
     * Business or Government badge type.
     */
    #[Optional]
    public ?string $verifiedType;

    /**
     * Organization affiliation label shown on an X profile.
     */
    #[Optional]
    public ?UserAffiliateLabel $affiliatesHighlightedLabel;

    /**
     * When the account joined the Space.
     */
    #[Optional]
    public ?\DateTimeInterface $joinedAt;

    /**
     * Whether a host muted the account.
     */
    #[Optional]
    public ?bool $isMutedByAdmin;

    /**
     * Whether the account muted itself.
     */
    #[Optional]
    public ?bool $isMutedByGuest;

    /**
     * The account's ID in X's broadcast service.
     */
    #[Optional('periscopeUserId')]
    public ?string $periscopeUserID;

    /**
     * `new SpaceParticipant()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SpaceParticipant::with(id: ..., username: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SpaceParticipant)->withId(...)->withUsername(...)->withName(...)
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
     * @param UserAffiliateLabel|array<string,mixed>|null $affiliatesHighlightedLabel
     */
    public static function with(string $id, string $username, string $name, ?string $profilePicture = null, ?string $profilePictureOriginal = null, ?bool $isVerified = null, ?bool $isBlueVerified = null, ?string $verifiedType = null, UserAffiliateLabel|array|null $affiliatesHighlightedLabel = null, ?\DateTimeInterface $joinedAt = null, ?bool $isMutedByAdmin = null, ?bool $isMutedByGuest = null, ?string $periscopeUserID = null): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['username'] = $username;
        $self['name'] = $name;

        null !== $profilePicture && $self['profilePicture'] = $profilePicture;
        null !== $profilePictureOriginal && $self['profilePictureOriginal'] = $profilePictureOriginal;
        null !== $isVerified && $self['isVerified'] = $isVerified;
        null !== $isBlueVerified && $self['isBlueVerified'] = $isBlueVerified;
        null !== $verifiedType && $self['verifiedType'] = $verifiedType;
        null !== $affiliatesHighlightedLabel && $self['affiliatesHighlightedLabel'] = $affiliatesHighlightedLabel;
        null !== $joinedAt && $self['joinedAt'] = $joinedAt;
        null !== $isMutedByAdmin && $self['isMutedByAdmin'] = $isMutedByAdmin;
        null !== $isMutedByGuest && $self['isMutedByGuest'] = $isMutedByGuest;
        null !== $periscopeUserID && $self['periscopeUserID'] = $periscopeUserID;

        return $self;
    }

    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withUsername(string $username): self
    {
        $self = clone $this;
        $self['username'] = $username;

        return $self;
    }

    /**
     * Name the account shows in the Space.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Profile picture URL.
     */
    public function withProfilePicture(?string $profilePicture): self
    {
        $self = clone $this;
        $self['profilePicture'] = $profilePicture;

        return $self;
    }

    /**
     * The participant's profile picture at full size.
     */
    public function withProfilePictureOriginal(?string $profilePictureOriginal): self
    {
        $self = clone $this;
        $self['profilePictureOriginal'] = $profilePictureOriginal;

        return $self;
    }

    /**
     * Whether X shows a verified badge in the Space.
     */
    public function withIsVerified(?bool $isVerified): self
    {
        $self = clone $this;
        $self['isVerified'] = $isVerified;

        return $self;
    }

    /**
     * Whether the account has X Premium verification.
     */
    public function withIsBlueVerified(?bool $isBlueVerified): self
    {
        $self = clone $this;
        $self['isBlueVerified'] = $isBlueVerified;

        return $self;
    }

    /**
     * Business or Government badge type.
     */
    public function withVerifiedType(?string $verifiedType): self
    {
        $self = clone $this;
        $self['verifiedType'] = $verifiedType;

        return $self;
    }

    /**
     * Organization affiliation label shown on an X profile.
     *
     * @param UserAffiliateLabel|array<string,mixed>|null $affiliatesHighlightedLabel
     */
    public function withAffiliatesHighlightedLabel(UserAffiliateLabel|array|null $affiliatesHighlightedLabel): self
    {
        $self = clone $this;
        $self['affiliatesHighlightedLabel'] = $affiliatesHighlightedLabel;

        return $self;
    }

    /**
     * When the account joined the Space.
     */
    public function withJoinedAt(?\DateTimeInterface $joinedAt): self
    {
        $self = clone $this;
        $self['joinedAt'] = $joinedAt;

        return $self;
    }

    /**
     * Whether a host muted the account.
     */
    public function withIsMutedByAdmin(?bool $isMutedByAdmin): self
    {
        $self = clone $this;
        $self['isMutedByAdmin'] = $isMutedByAdmin;

        return $self;
    }

    /**
     * Whether the account muted itself.
     */
    public function withIsMutedByGuest(?bool $isMutedByGuest): self
    {
        $self = clone $this;
        $self['isMutedByGuest'] = $isMutedByGuest;

        return $self;
    }

    /**
     * The account's ID in X's broadcast service.
     */
    public function withPeriscopeUserID(?string $periscopeUserID): self
    {
        $self = clone $this;
        $self['periscopeUserID'] = $periscopeUserID;

        return $self;
    }
}
