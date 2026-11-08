<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Monitors\Keywords;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Monitors\Keywords\KeywordDeactivateResponse\DeletionStatus;

/**
 * @phpstan-type KeywordDeactivateResponseShape = array{success: bool,
 *   deletionStatus?: DeletionStatus|value-of<DeletionStatus>|null,
 *   statusUrl?: string|null,
 * }
 */
final class KeywordDeactivateResponse implements BaseModel
{
    /** @use SdkModel<KeywordDeactivateResponseShape> */
    use SdkModel;

    #[Required]
    public bool $success = true;

    /**
     * @var value-of<DeletionStatus>|null $deletionStatus
     */
    #[Optional(enum: DeletionStatus::class)]
    public ?string $deletionStatus;

    /**
     * Poll this monitor URL until it returns 404.
     */
    #[Optional]
    public ?string $statusUrl;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param DeletionStatus|value-of<DeletionStatus>|null $deletionStatus
     */
    public static function with(DeletionStatus|string|null $deletionStatus = null, ?string $statusUrl = null): self
    {
        $self = new self;

        null !== $deletionStatus && $self['deletionStatus'] = $deletionStatus;

        null !== $statusUrl && $self['statusUrl'] = $statusUrl;

        return $self;
    }

    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }

    /**
     * @param DeletionStatus|value-of<DeletionStatus>|null $deletionStatus
     */
    public function withDeletionStatus(DeletionStatus|string|null $deletionStatus): self
    {
        $self = clone $this;
        $self['deletionStatus'] = $deletionStatus;

        return $self;
    }

    /**
     * Poll this monitor URL until it returns 404.
     */
    public function withStatusUrl(?string $statusUrl): self
    {
        $self = clone $this;
        $self['statusUrl'] = $statusUrl;

        return $self;
    }
}
