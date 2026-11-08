<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ActivityRecord;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TimestampsShape = array{
 *   createdAt: \DateTimeInterface,
 *   updatedAt?: \DateTimeInterface|null,
 *   completedAt?: \DateTimeInterface|null,
 *   confirmedAt?: \DateTimeInterface|null,
 *   expiresAt?: \DateTimeInterface|null,
 *   occurredAt?: \DateTimeInterface|null,
 *   discoveredAt?: \DateTimeInterface|null,
 *   postedAt?: \DateTimeInterface|null,
 *   firstAttemptedAt?: \DateTimeInterface|null,
 *   deliveredAt?: \DateTimeInterface|null,
 *   nextRetryAt?: \DateTimeInterface|null,
 *   exhaustedAt?: \DateTimeInterface|null,
 *   drawnAt?: \DateTimeInterface|null,
 *   lastUsedAt?: \DateTimeInterface|null,
 *   pausedAt?: \DateTimeInterface|null,
 * }
 */
final class Timestamps implements BaseModel
{
    /** @use SdkModel<TimestampsShape> */
    use SdkModel;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    #[Optional]
    public ?\DateTimeInterface $completedAt;

    #[Optional]
    public ?\DateTimeInterface $confirmedAt;

    #[Optional]
    public ?\DateTimeInterface $expiresAt;

    #[Optional]
    public ?\DateTimeInterface $occurredAt;

    #[Optional]
    public ?\DateTimeInterface $discoveredAt;

    #[Optional]
    public ?\DateTimeInterface $postedAt;

    #[Optional]
    public ?\DateTimeInterface $firstAttemptedAt;

    #[Optional]
    public ?\DateTimeInterface $deliveredAt;

    #[Optional]
    public ?\DateTimeInterface $nextRetryAt;

    #[Optional]
    public ?\DateTimeInterface $exhaustedAt;

    #[Optional]
    public ?\DateTimeInterface $drawnAt;

    #[Optional]
    public ?\DateTimeInterface $lastUsedAt;

    #[Optional]
    public ?\DateTimeInterface $pausedAt;

    /**
     * `new Timestamps()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Timestamps::with(createdAt: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Timestamps)->withCreatedAt(...)
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
    public static function with(\DateTimeInterface $createdAt, ?\DateTimeInterface $updatedAt = null, ?\DateTimeInterface $completedAt = null, ?\DateTimeInterface $confirmedAt = null, ?\DateTimeInterface $expiresAt = null, ?\DateTimeInterface $occurredAt = null, ?\DateTimeInterface $discoveredAt = null, ?\DateTimeInterface $postedAt = null, ?\DateTimeInterface $firstAttemptedAt = null, ?\DateTimeInterface $deliveredAt = null, ?\DateTimeInterface $nextRetryAt = null, ?\DateTimeInterface $exhaustedAt = null, ?\DateTimeInterface $drawnAt = null, ?\DateTimeInterface $lastUsedAt = null, ?\DateTimeInterface $pausedAt = null): self
    {
        $self = new self;

        $self['createdAt'] = $createdAt;

        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $completedAt && $self['completedAt'] = $completedAt;
        null !== $confirmedAt && $self['confirmedAt'] = $confirmedAt;
        null !== $expiresAt && $self['expiresAt'] = $expiresAt;
        null !== $occurredAt && $self['occurredAt'] = $occurredAt;
        null !== $discoveredAt && $self['discoveredAt'] = $discoveredAt;
        null !== $postedAt && $self['postedAt'] = $postedAt;
        null !== $firstAttemptedAt && $self['firstAttemptedAt'] = $firstAttemptedAt;
        null !== $deliveredAt && $self['deliveredAt'] = $deliveredAt;
        null !== $nextRetryAt && $self['nextRetryAt'] = $nextRetryAt;
        null !== $exhaustedAt && $self['exhaustedAt'] = $exhaustedAt;
        null !== $drawnAt && $self['drawnAt'] = $drawnAt;
        null !== $lastUsedAt && $self['lastUsedAt'] = $lastUsedAt;
        null !== $pausedAt && $self['pausedAt'] = $pausedAt;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withCompletedAt(?\DateTimeInterface $completedAt): self
    {
        $self = clone $this;
        $self['completedAt'] = $completedAt;

        return $self;
    }

    public function withConfirmedAt(?\DateTimeInterface $confirmedAt): self
    {
        $self = clone $this;
        $self['confirmedAt'] = $confirmedAt;

        return $self;
    }

    public function withExpiresAt(?\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }

    public function withOccurredAt(?\DateTimeInterface $occurredAt): self
    {
        $self = clone $this;
        $self['occurredAt'] = $occurredAt;

        return $self;
    }

    public function withDiscoveredAt(?\DateTimeInterface $discoveredAt): self
    {
        $self = clone $this;
        $self['discoveredAt'] = $discoveredAt;

        return $self;
    }

    public function withPostedAt(?\DateTimeInterface $postedAt): self
    {
        $self = clone $this;
        $self['postedAt'] = $postedAt;

        return $self;
    }

    public function withFirstAttemptedAt(?\DateTimeInterface $firstAttemptedAt): self
    {
        $self = clone $this;
        $self['firstAttemptedAt'] = $firstAttemptedAt;

        return $self;
    }

    public function withDeliveredAt(?\DateTimeInterface $deliveredAt): self
    {
        $self = clone $this;
        $self['deliveredAt'] = $deliveredAt;

        return $self;
    }

    public function withNextRetryAt(?\DateTimeInterface $nextRetryAt): self
    {
        $self = clone $this;
        $self['nextRetryAt'] = $nextRetryAt;

        return $self;
    }

    public function withExhaustedAt(?\DateTimeInterface $exhaustedAt): self
    {
        $self = clone $this;
        $self['exhaustedAt'] = $exhaustedAt;

        return $self;
    }

    public function withDrawnAt(?\DateTimeInterface $drawnAt): self
    {
        $self = clone $this;
        $self['drawnAt'] = $drawnAt;

        return $self;
    }

    public function withLastUsedAt(?\DateTimeInterface $lastUsedAt): self
    {
        $self = clone $this;
        $self['lastUsedAt'] = $lastUsedAt;

        return $self;
    }

    public function withPausedAt(?\DateTimeInterface $pausedAt): self
    {
        $self = clone $this;
        $self['pausedAt'] = $pausedAt;

        return $self;
    }
}
