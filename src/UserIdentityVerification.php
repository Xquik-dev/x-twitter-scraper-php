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
 * @phpstan-type UserIdentityVerificationShape = array{
 *   description?: string|null,
 *   isIdentityVerified?: bool|null,
 *   overrideVerifiedYear?: int|null,
 *   verifiedSinceMsec?: string|null,
 * }
 */
final class UserIdentityVerification implements BaseModel
{
    /** @use SdkModel<UserIdentityVerificationShape> */
    use SdkModel;

    #[Optional]
    public ?string $description;

    /**
     * Whether the owner verified their ID with X.
     */
    #[Optional]
    public ?bool $isIdentityVerified;

    /**
     * The year X shows as the start of verification, in place of verifiedSinceMsec.
     */
    #[Optional]
    public ?int $overrideVerifiedYear;

    /**
     * When X verified the account, in milliseconds since 1970, as text.
     */
    #[Optional]
    public ?string $verifiedSinceMsec;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $description = null, ?bool $isIdentityVerified = null, ?int $overrideVerifiedYear = null, ?string $verifiedSinceMsec = null): self
    {
        $self = new self;

        null !== $description && $self['description'] = $description;
        null !== $isIdentityVerified && $self['isIdentityVerified'] = $isIdentityVerified;
        null !== $overrideVerifiedYear && $self['overrideVerifiedYear'] = $overrideVerifiedYear;
        null !== $verifiedSinceMsec && $self['verifiedSinceMsec'] = $verifiedSinceMsec;

        return $self;
    }

    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Whether the owner verified their ID with X.
     */
    public function withIsIdentityVerified(?bool $isIdentityVerified): self
    {
        $self = clone $this;
        $self['isIdentityVerified'] = $isIdentityVerified;

        return $self;
    }

    /**
     * The year X shows as the start of verification, in place of verifiedSinceMsec.
     */
    public function withOverrideVerifiedYear(?int $overrideVerifiedYear): self
    {
        $self = clone $this;
        $self['overrideVerifiedYear'] = $overrideVerifiedYear;

        return $self;
    }

    /**
     * When X verified the account, in milliseconds since 1970, as text.
     */
    public function withVerifiedSinceMsec(?string $verifiedSinceMsec): self
    {
        $self = clone $this;
        $self['verifiedSinceMsec'] = $verifiedSinceMsec;

        return $self;
    }
}
