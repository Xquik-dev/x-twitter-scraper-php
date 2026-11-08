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
 * @phpstan-type JobAccountShape = array{
 *   id: string,
 *   verified: bool,
 *   username?: string|null,
 *   name?: string|null,
 *   verifiedType?: string|null,
 *   description?: string|null,
 *   profilePicture?: string|null,
 *   profilePictureOriginal?: string|null,
 *   profileImageShape?: string|null,
 * }
 */
final class JobAccount implements BaseModel
{
    /** @use SdkModel<JobAccountShape> */
    use SdkModel;

    /**
     * X user ID of the account.
     */
    #[Required]
    public string $id;

    /**
     * Whether X shows a verification badge on the account.
     */
    #[Required]
    public bool $verified;

    /**
     * Handle without @.
     */
    #[Optional]
    public ?string $username;

    /**
     * Display name of the account that posted the job.
     */
    #[Optional]
    public ?string $name;

    /**
     * Badge type, such as Business or Government.
     */
    #[Optional]
    public ?string $verifiedType;

    /**
     * Bio of the account. A job lookup returns it.
     */
    #[Optional]
    public ?string $description;

    /**
     * Avatar URL of the account that posted the job.
     */
    #[Optional]
    public ?string $profilePicture;

    /**
     * The job account's avatar at full size.
     */
    #[Optional]
    public ?string $profilePictureOriginal;

    /**
     * Avatar shape, such as Circle or Square.
     */
    #[Optional]
    public ?string $profileImageShape;

    /**
     * `new JobAccount()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * JobAccount::with(id: ..., verified: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new JobAccount)->withId(...)->withVerified(...)
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
    public static function with(string $id, bool $verified, ?string $username = null, ?string $name = null, ?string $verifiedType = null, ?string $description = null, ?string $profilePicture = null, ?string $profilePictureOriginal = null, ?string $profileImageShape = null): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['verified'] = $verified;

        null !== $username && $self['username'] = $username;
        null !== $name && $self['name'] = $name;
        null !== $verifiedType && $self['verifiedType'] = $verifiedType;
        null !== $description && $self['description'] = $description;
        null !== $profilePicture && $self['profilePicture'] = $profilePicture;
        null !== $profilePictureOriginal && $self['profilePictureOriginal'] = $profilePictureOriginal;
        null !== $profileImageShape && $self['profileImageShape'] = $profileImageShape;

        return $self;
    }

    /**
     * X user ID of the account.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Whether X shows a verification badge on the account.
     */
    public function withVerified(bool $verified): self
    {
        $self = clone $this;
        $self['verified'] = $verified;

        return $self;
    }

    /**
     * Handle without @.
     */
    public function withUsername(?string $username): self
    {
        $self = clone $this;
        $self['username'] = $username;

        return $self;
    }

    /**
     * Display name of the account that posted the job.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Badge type, such as Business or Government.
     */
    public function withVerifiedType(?string $verifiedType): self
    {
        $self = clone $this;
        $self['verifiedType'] = $verifiedType;

        return $self;
    }

    /**
     * Bio of the account. A job lookup returns it.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Avatar URL of the account that posted the job.
     */
    public function withProfilePicture(?string $profilePicture): self
    {
        $self = clone $this;
        $self['profilePicture'] = $profilePicture;

        return $self;
    }

    /**
     * The job account's avatar at full size.
     */
    public function withProfilePictureOriginal(?string $profilePictureOriginal): self
    {
        $self = clone $this;
        $self['profilePictureOriginal'] = $profilePictureOriginal;

        return $self;
    }

    /**
     * Avatar shape, such as Circle or Square.
     */
    public function withProfileImageShape(?string $profileImageShape): self
    {
        $self = clone $this;
        $self['profileImageShape'] = $profileImageShape;

        return $self;
    }
}
