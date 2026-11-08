<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Monitors;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Monitors\MonitorUpsertByUsernameResponse\EventTypes;
use XTwitterScraper\Monitors\MonitorUpsertByUsernameResponse\PausedReason;

/**
 * @phpstan-type MonitorUpsertByUsernameResponseShape = array{
 *   id: string,
 *   username: string,
 *   xUserID: string,
 *   eventTypes: list<EventTypes|value-of<EventTypes>>,
 *   isActive: bool,
 *   createdAt: \DateTimeInterface,
 *   nextBillingAt: \DateTimeInterface,
 *   created: bool,
 *   name?: string|null,
 *   pausedReason?: PausedReason|value-of<PausedReason>|null,
 *   pausedAt?: \DateTimeInterface|null,
 * }
 */
final class MonitorUpsertByUsernameResponse implements BaseModel
{
    /** @use SdkModel<MonitorUpsertByUsernameResponseShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $username;

    #[Required('xUserId')]
    public string $xUserID;

    /**
     * Array of event types to subscribe to.
     *
     * @var list<value-of<EventTypes>> $eventTypes
     */
    #[Required(list: EventTypes::class)]
    public array $eventTypes;

    #[Required]
    public bool $isActive;

    #[Required]
    public \DateTimeInterface $createdAt;

    /**
     * Next hourly credit charge time for this account monitor.
     */
    #[Required]
    public \DateTimeInterface $nextBillingAt;

    /**
     * False, since this call updated a running monitor.
     */
    #[Required]
    public bool $created;

    /**
     * Customer-set label of the account monitor, when set.
     */
    #[Optional]
    public ?string $name;

    /**
     * Why Xquik paused this account monitor. `insufficient_credits` means the balance could not pay an hour, so add credits & resume. The other 2 mean X stopped showing the account. Absent when the monitor is active or you paused it yourself.
     *
     * @var value-of<PausedReason>|null $pausedReason
     */
    #[Optional(enum: PausedReason::class)]
    public ?string $pausedReason;

    /**
     * When Xquik paused this account monitor.
     */
    #[Optional]
    public ?\DateTimeInterface $pausedAt;

    /**
     * `new MonitorUpsertByUsernameResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MonitorUpsertByUsernameResponse::with(id: ..., username: ..., xUserID: ..., eventTypes: ..., isActive: ..., createdAt: ..., nextBillingAt: ..., created: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MonitorUpsertByUsernameResponse)->withId(...)->withUsername(...)->withXUserID(...)->withEventTypes(...)->withIsActive(...)->withCreatedAt(...)->withNextBillingAt(...)->withCreated(...)
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
     * @param list<EventTypes|value-of<EventTypes>> $eventTypes
     * @param PausedReason|value-of<PausedReason>|null $pausedReason
     */
    public static function with(string $id, string $username, string $xUserID, array $eventTypes, bool $isActive, \DateTimeInterface $createdAt, \DateTimeInterface $nextBillingAt, bool $created, ?string $name = null, PausedReason|string|null $pausedReason = null, ?\DateTimeInterface $pausedAt = null): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['username'] = $username;
        $self['xUserID'] = $xUserID;
        $self['eventTypes'] = $eventTypes;
        $self['isActive'] = $isActive;
        $self['createdAt'] = $createdAt;
        $self['nextBillingAt'] = $nextBillingAt;
        $self['created'] = $created;

        null !== $name && $self['name'] = $name;
        null !== $pausedReason && $self['pausedReason'] = $pausedReason;
        null !== $pausedAt && $self['pausedAt'] = $pausedAt;

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

    public function withXUserID(string $xUserID): self
    {
        $self = clone $this;
        $self['xUserID'] = $xUserID;

        return $self;
    }

    /**
     * Array of event types to subscribe to.
     *
     * @param list<EventTypes|value-of<EventTypes>> $eventTypes
     */
    public function withEventTypes(array $eventTypes): self
    {
        $self = clone $this;
        $self['eventTypes'] = $eventTypes;

        return $self;
    }

    public function withIsActive(bool $isActive): self
    {
        $self = clone $this;
        $self['isActive'] = $isActive;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Next hourly credit charge time for this account monitor.
     */
    public function withNextBillingAt(\DateTimeInterface $nextBillingAt): self
    {
        $self = clone $this;
        $self['nextBillingAt'] = $nextBillingAt;

        return $self;
    }

    /**
     * False, since this call updated a running monitor.
     */
    public function withCreated(bool $created): self
    {
        $self = clone $this;
        $self['created'] = $created;

        return $self;
    }

    /**
     * Customer-set label of the account monitor, when set.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Why Xquik paused this account monitor. `insufficient_credits` means the balance could not pay an hour, so add credits & resume. The other 2 mean X stopped showing the account. Absent when the monitor is active or you paused it yourself.
     *
     * @param PausedReason|value-of<PausedReason>|null $pausedReason
     */
    public function withPausedReason(PausedReason|string|null $pausedReason): self
    {
        $self = clone $this;
        $self['pausedReason'] = $pausedReason;

        return $self;
    }

    /**
     * When Xquik paused this account monitor.
     */
    public function withPausedAt(?\DateTimeInterface $pausedAt): self
    {
        $self = clone $this;
        $self['pausedAt'] = $pausedAt;

        return $self;
    }
}
