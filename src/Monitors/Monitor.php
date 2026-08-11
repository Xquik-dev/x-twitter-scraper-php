<?php

declare(strict_types=1);

namespace XTwitterScraper\Monitors;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\EventType;
use XTwitterScraper\Monitors\Monitor\PausedReason;

/**
 * Account monitor that tracks activity for a given X user.
 *
 * @phpstan-type MonitorShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   eventTypes: list<EventType|value-of<EventType>>,
 *   isActive: bool,
 *   nextBillingAt: \DateTimeInterface,
 *   username: string,
 *   xUserID: string,
 *   pausedAt?: \DateTimeInterface|null,
 *   pausedReason?: null|PausedReason|value-of<PausedReason>,
 * }
 */
final class Monitor implements BaseModel
{
    /** @use SdkModel<MonitorShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    /**
     * Array of event types to subscribe to.
     *
     * @var list<value-of<EventType>> $eventTypes
     */
    #[Required(list: EventType::class)]
    public array $eventTypes;

    #[Required]
    public bool $isActive;

    /**
     * Next hourly credit charge time for this account monitor.
     */
    #[Required]
    public \DateTimeInterface $nextBillingAt;

    #[Required]
    public string $username;

    #[Required('xUserId')]
    public string $xUserID;

    /**
     * When Xquik automatically paused this monitor.
     */
    #[Optional]
    public ?\DateTimeInterface $pausedAt;

    /**
     * Why Xquik automatically paused this monitor.
     *
     * @var value-of<PausedReason>|null $pausedReason
     */
    #[Optional(enum: PausedReason::class)]
    public ?string $pausedReason;

    /**
     * `new Monitor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Monitor::with(
     *   id: ...,
     *   createdAt: ...,
     *   eventTypes: ...,
     *   isActive: ...,
     *   nextBillingAt: ...,
     *   username: ...,
     *   xUserID: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Monitor)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withEventTypes(...)
     *   ->withIsActive(...)
     *   ->withNextBillingAt(...)
     *   ->withUsername(...)
     *   ->withXUserID(...)
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
     * @param list<EventType|value-of<EventType>> $eventTypes
     * @param PausedReason|value-of<PausedReason>|null $pausedReason
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        array $eventTypes,
        bool $isActive,
        \DateTimeInterface $nextBillingAt,
        string $username,
        string $xUserID,
        ?\DateTimeInterface $pausedAt = null,
        PausedReason|string|null $pausedReason = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['eventTypes'] = $eventTypes;
        $self['isActive'] = $isActive;
        $self['nextBillingAt'] = $nextBillingAt;
        $self['username'] = $username;
        $self['xUserID'] = $xUserID;

        null !== $pausedAt && $self['pausedAt'] = $pausedAt;
        null !== $pausedReason && $self['pausedReason'] = $pausedReason;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Array of event types to subscribe to.
     *
     * @param list<EventType|value-of<EventType>> $eventTypes
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

    /**
     * Next hourly credit charge time for this account monitor.
     */
    public function withNextBillingAt(\DateTimeInterface $nextBillingAt): self
    {
        $self = clone $this;
        $self['nextBillingAt'] = $nextBillingAt;

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
     * When Xquik automatically paused this monitor.
     */
    public function withPausedAt(\DateTimeInterface $pausedAt): self
    {
        $self = clone $this;
        $self['pausedAt'] = $pausedAt;

        return $self;
    }

    /**
     * Why Xquik automatically paused this monitor.
     *
     * @param PausedReason|value-of<PausedReason> $pausedReason
     */
    public function withPausedReason(PausedReason|string $pausedReason): self
    {
        $self = clone $this;
        $self['pausedReason'] = $pausedReason;

        return $self;
    }
}
