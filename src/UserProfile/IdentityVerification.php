<?php

declare(strict_types=1);

namespace XTwitterScraper\UserProfile;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Identity verification metadata displayed by X.
 *
 * @phpstan-type IdentityVerificationShape = array{
 *   description?: string|null,
 *   isIdentityVerified?: bool|null,
 *   verifiedSinceMsec?: string|null,
 * }
 */
final class IdentityVerification implements BaseModel
{
    /** @use SdkModel<IdentityVerificationShape> */
    use SdkModel;

    #[Optional]
    public ?string $description;

    #[Optional]
    public ?bool $isIdentityVerified;

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
    public static function with(
        ?string $description = null,
        ?bool $isIdentityVerified = null,
        ?string $verifiedSinceMsec = null,
    ): self {
        $self = new self;

        null !== $description && $self['description'] = $description;
        null !== $isIdentityVerified && $self['isIdentityVerified'] = $isIdentityVerified;
        null !== $verifiedSinceMsec && $self['verifiedSinceMsec'] = $verifiedSinceMsec;

        return $self;
    }

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withIsIdentityVerified(bool $isIdentityVerified): self
    {
        $self = clone $this;
        $self['isIdentityVerified'] = $isIdentityVerified;

        return $self;
    }

    public function withVerifiedSinceMsec(string $verifiedSinceMsec): self
    {
        $self = clone $this;
        $self['verifiedSinceMsec'] = $verifiedSinceMsec;

        return $self;
    }
}
