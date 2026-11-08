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
use XTwitterScraper\EventType;
use XTwitterScraper\Monitors\Keywords\KeywordGetResponse\PausedReason;

/**
 * Keyword monitor that tracks matching public X activity.
 *
 * @phpstan-type KeywordGetResponseShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   eventTypes: list<EventType|value-of<EventType>>,
 *   isActive: bool,
 *   nextBillingAt: \DateTimeInterface,
 *   query: string,
 *   name?: string|null,
 *   pausedReason?: PausedReason|value-of<PausedReason>|null,
 *   pausedAt?: \DateTimeInterface|null,
 * }
 */
final class KeywordGetResponse implements BaseModel
{
    /** @use SdkModel<KeywordGetResponseShape> */
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
     * Next hourly credit charge time for this keyword query monitor.
     */
    #[Required]
    public \DateTimeInterface $nextBillingAt;

    #[Required]
    public string $query;

    /**
     * Customer-set label of the keyword monitor, when set.
     */
    #[Optional]
    public ?string $name;

    /**
     * Why Xquik paused this keyword monitor. The balance could not pay an hour, so add credits & resume. Absent when the monitor is active or you paused it yourself.
     *
     * @var value-of<PausedReason>|null $pausedReason
     */
    #[Optional(enum: PausedReason::class)]
    public ?string $pausedReason;

    /**
     * When Xquik paused this keyword monitor.
     */
    #[Optional]
    public ?\DateTimeInterface $pausedAt;

    /**
     * `new KeywordGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * KeywordGetResponse::with(
     *   id: ...,
     *   createdAt: ...,
     *   eventTypes: ...,
     *   isActive: ...,
     *   nextBillingAt: ...,
     *   query: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new KeywordGetResponse)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withEventTypes(...)
     *   ->withIsActive(...)
     *   ->withNextBillingAt(...)
     *   ->withQuery(...)
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
        string $query,
        ?string $name = null,
        PausedReason|string|null $pausedReason = null,
        ?\DateTimeInterface $pausedAt = null
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['eventTypes'] = $eventTypes;
        $self['isActive'] = $isActive;
        $self['nextBillingAt'] = $nextBillingAt;
        $self['query'] = $query;

        null !== $name && $self['name'] = $name;

        null !== $pausedReason && $self['pausedReason'] = $pausedReason;

        null !== $pausedAt && $self['pausedAt'] = $pausedAt;

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
     * Next hourly credit charge time for this keyword query monitor.
     */
    public function withNextBillingAt(\DateTimeInterface $nextBillingAt): self
    {
        $self = clone $this;
        $self['nextBillingAt'] = $nextBillingAt;

        return $self;
    }

    public function withQuery(string $query): self
    {
        $self = clone $this;
        $self['query'] = $query;

        return $self;
    }

    /**
     * Customer-set label of the keyword monitor, when set.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Why Xquik paused this keyword monitor. The balance could not pay an hour, so add credits & resume. Absent when the monitor is active or you paused it yourself.
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
     * When Xquik paused this keyword monitor.
     */
    public function withPausedAt(?\DateTimeInterface $pausedAt): self
    {
        $self = clone $this;
        $self['pausedAt'] = $pausedAt;

        return $self;
    }
}
