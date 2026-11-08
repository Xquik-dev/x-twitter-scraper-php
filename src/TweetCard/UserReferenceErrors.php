<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetCard;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type UserReferenceErrorsShape = array{
 *   message?: string|null,
 *   reason?: string|null,
 * }
 */
final class UserReferenceErrors implements BaseModel
{
    /** @use SdkModel<UserReferenceErrorsShape> */
    use SdkModel;

    #[Optional]
    public ?string $message;

    #[Optional]
    public ?string $reason;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $message = null, ?string $reason = null): self
    {
        $self = new self;

        null !== $message && $self['message'] = $message;
        null !== $reason && $self['reason'] = $reason;

        return $self;
    }

    public function withMessage(?string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    public function withReason(?string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }
}
