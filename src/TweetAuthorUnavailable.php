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
 * @phpstan-type TweetAuthorUnavailableShape = array{
 *   reason: string,
 *   message?: string|null,
 * }
 */
final class TweetAuthorUnavailable implements BaseModel
{
    /** @use SdkModel<TweetAuthorUnavailableShape> */
    use SdkModel;

    /**
     * X's reason code.
     */
    #[Required]
    public string $reason;

    /**
     * X's notice text for the reason.
     */
    #[Optional]
    public ?string $message;

    /**
     * `new TweetAuthorUnavailable()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetAuthorUnavailable::with(reason: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetAuthorUnavailable)->withReason(...)
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
    public static function with(string $reason, ?string $message = null): self
    {
        $self = new self;

        $self['reason'] = $reason;

        null !== $message && $self['message'] = $message;

        return $self;
    }

    /**
     * X's reason code.
     */
    public function withReason(string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * X's notice text for the reason.
     */
    public function withMessage(?string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
