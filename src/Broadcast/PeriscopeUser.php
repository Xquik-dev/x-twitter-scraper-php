<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Broadcast;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type PeriscopeUserShape = array{
 *   id?: string|null,
 *   username?: string|null,
 *   displayName?: string|null,
 *   profilePicture?: string|null,
 *   profilePictureOriginal?: string|null,
 * }
 */
final class PeriscopeUser implements BaseModel
{
    /** @use SdkModel<PeriscopeUserShape> */
    use SdkModel;

    /**
     * Live video account ID.
     */
    #[Optional]
    public ?string $id;

    /**
     * Live video username.
     */
    #[Optional]
    public ?string $username;

    /**
     * Live video display name.
     */
    #[Optional]
    public ?string $displayName;

    /**
     * Live video avatar URL.
     */
    #[Optional]
    public ?string $profilePicture;

    /**
     * The broadcaster's avatar at full size.
     */
    #[Optional]
    public ?string $profilePictureOriginal;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $id = null, ?string $username = null, ?string $displayName = null, ?string $profilePicture = null, ?string $profilePictureOriginal = null): self
    {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $username && $self['username'] = $username;
        null !== $displayName && $self['displayName'] = $displayName;
        null !== $profilePicture && $self['profilePicture'] = $profilePicture;
        null !== $profilePictureOriginal && $self['profilePictureOriginal'] = $profilePictureOriginal;

        return $self;
    }

    /**
     * Live video account ID.
     */
    public function withId(?string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Live video username.
     */
    public function withUsername(?string $username): self
    {
        $self = clone $this;
        $self['username'] = $username;

        return $self;
    }

    /**
     * Live video display name.
     */
    public function withDisplayName(?string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * Live video avatar URL.
     */
    public function withProfilePicture(?string $profilePicture): self
    {
        $self = clone $this;
        $self['profilePicture'] = $profilePicture;

        return $self;
    }

    /**
     * The broadcaster's avatar at full size.
     */
    public function withProfilePictureOriginal(?string $profilePictureOriginal): self
    {
        $self = clone $this;
        $self['profilePictureOriginal'] = $profilePictureOriginal;

        return $self;
    }
}
