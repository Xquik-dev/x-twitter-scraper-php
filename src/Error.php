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
use XTwitterScraper\Error\Error\LegacyErrorCode;
use XTwitterScraper\Error\Error\StructuredError;

/**
 * Error response. Default v1 returns a legacy string error code. Send `xquik-api-contract: 2026-04-29` to receive the structured best-practice error object.
 *
 * @phpstan-import-type ErrorVariants from \XTwitterScraper\Error\Error
 * @phpstan-import-type ErrorShape from \XTwitterScraper\Error\Error as ErrorShape1
 *
 * @phpstan-type ErrorShape = array{
 *   error: ErrorShape1,
 *   message?: string|null,
 *   reason?: string|null,
 *   retryAfter?: int|null,
 *   retryAfterMs?: int|null,
 * }
 */
final class Error implements BaseModel
{
    /** @use SdkModel<ErrorShape> */
    use SdkModel;

    /** @var ErrorVariants $error */
    #[Required(union: Error\Error::class)]
    public StructuredError|string $error;

    /**
     * Human-readable error guidance.
     */
    #[Optional]
    public ?string $message;

    /**
     * Machine-readable reason for a login cooldown.
     */
    #[Optional]
    public ?string $reason;

    /**
     * Seconds until the next permitted request.
     */
    #[Optional]
    public ?int $retryAfter;

    /**
     * Required wait in milliseconds.
     */
    #[Optional]
    public ?int $retryAfterMs;

    /**
     * `new Error()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Error::with(error: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Error)->withError(...)
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
     * @param ErrorShape1 $error
     */
    public static function with(
        LegacyErrorCode|StructuredError|array|string $error,
        ?string $message = null,
        ?string $reason = null,
        ?int $retryAfter = null,
        ?int $retryAfterMs = null,
    ): self {
        $self = new self;

        $self['error'] = $error;

        null !== $message && $self['message'] = $message;
        null !== $reason && $self['reason'] = $reason;
        null !== $retryAfter && $self['retryAfter'] = $retryAfter;
        null !== $retryAfterMs && $self['retryAfterMs'] = $retryAfterMs;

        return $self;
    }

    /**
     * @param ErrorShape1 $error
     */
    public function withError(
        LegacyErrorCode|StructuredError|array|string $error
    ): self {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * Human-readable error guidance.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * Machine-readable reason for a login cooldown.
     */
    public function withReason(string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * Seconds until the next permitted request.
     */
    public function withRetryAfter(int $retryAfter): self
    {
        $self = clone $this;
        $self['retryAfter'] = $retryAfter;

        return $self;
    }

    /**
     * Required wait in milliseconds.
     */
    public function withRetryAfterMs(int $retryAfterMs): self
    {
        $self = clone $this;
        $self['retryAfterMs'] = $retryAfterMs;

        return $self;
    }
}
