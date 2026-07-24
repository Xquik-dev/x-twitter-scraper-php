<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Events;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Events\EventDetail\MonitorType;
use XTwitterScraper\EventType;

/**
 * Full monitor event including payload data and optional X event ID.
 *
 * @phpstan-type EventDetailShape = array{
 *   id: string,
 *   data: array<string,mixed>,
 *   monitorID: string,
 *   monitorType: MonitorType|value-of<MonitorType>,
 *   occurredAt: \DateTimeInterface,
 *   type: EventType|value-of<EventType>,
 *   keywordMonitorID?: string|null,
 *   query?: string|null,
 *   username?: string|null,
 *   xEventID?: string|null,
 * }
 */
final class EventDetail implements BaseModel
{
    /** @use SdkModel<EventDetailShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /**
     * Event payload - shape varies by event type (JSON).
     *
     * @var array<string,mixed> $data
     */
    #[Required(map: 'mixed')]
    public array $data;

    /**
     * Monitor ID associated with this detailed event payload.
     */
    #[Required('monitorId')]
    public string $monitorID;

    /**
     * Source monitor type for this detailed event.
     *
     * @var value-of<MonitorType> $monitorType
     */
    #[Required(enum: MonitorType::class)]
    public string $monitorType;

    #[Required]
    public \DateTimeInterface $occurredAt;

    /**
     * Type of monitor event fired when account activity occurs.
     *
     * @var value-of<EventType> $type
     */
    #[Required(enum: EventType::class)]
    public string $type;

    /**
     * Keyword monitor ID included on detailed keyword events.
     */
    #[Optional('keywordMonitorId')]
    public ?string $keywordMonitorID;

    /**
     * Keyword query for this detailed monitor event.
     */
    #[Optional]
    public ?string $query;

    /**
     * Account username for this detailed monitor event.
     */
    #[Optional]
    public ?string $username;

    #[Optional('xEventId')]
    public ?string $xEventID;

    /**
     * `new EventDetail()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * EventDetail::with(
     *   id: ...,
     *   data: ...,
     *   monitorID: ...,
     *   monitorType: ...,
     *   occurredAt: ...,
     *   type: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new EventDetail)
     *   ->withID(...)
     *   ->withData(...)
     *   ->withMonitorID(...)
     *   ->withMonitorType(...)
     *   ->withOccurredAt(...)
     *   ->withType(...)
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
     * @param array<string,mixed> $data
     * @param MonitorType|value-of<MonitorType> $monitorType
     * @param EventType|value-of<EventType> $type
     */
    public static function with(
        string $id,
        array $data,
        string $monitorID,
        MonitorType|string $monitorType,
        \DateTimeInterface $occurredAt,
        EventType|string $type,
        ?string $keywordMonitorID = null,
        ?string $query = null,
        ?string $username = null,
        ?string $xEventID = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['data'] = $data;
        $self['monitorID'] = $monitorID;
        $self['monitorType'] = $monitorType;
        $self['occurredAt'] = $occurredAt;
        $self['type'] = $type;

        null !== $keywordMonitorID && $self['keywordMonitorID'] = $keywordMonitorID;
        null !== $query && $self['query'] = $query;
        null !== $username && $self['username'] = $username;
        null !== $xEventID && $self['xEventID'] = $xEventID;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Event payload - shape varies by event type (JSON).
     *
     * @param array<string,mixed> $data
     */
    public function withData(array $data): self
    {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }

    /**
     * Monitor ID associated with this detailed event payload.
     */
    public function withMonitorID(string $monitorID): self
    {
        $self = clone $this;
        $self['monitorID'] = $monitorID;

        return $self;
    }

    /**
     * Source monitor type for this detailed event.
     *
     * @param MonitorType|value-of<MonitorType> $monitorType
     */
    public function withMonitorType(MonitorType|string $monitorType): self
    {
        $self = clone $this;
        $self['monitorType'] = $monitorType;

        return $self;
    }

    public function withOccurredAt(\DateTimeInterface $occurredAt): self
    {
        $self = clone $this;
        $self['occurredAt'] = $occurredAt;

        return $self;
    }

    /**
     * Type of monitor event fired when account activity occurs.
     *
     * @param EventType|value-of<EventType> $type
     */
    public function withType(EventType|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Keyword monitor ID included on detailed keyword events.
     */
    public function withKeywordMonitorID(string $keywordMonitorID): self
    {
        $self = clone $this;
        $self['keywordMonitorID'] = $keywordMonitorID;

        return $self;
    }

    /**
     * Keyword query for this detailed monitor event.
     */
    public function withQuery(string $query): self
    {
        $self = clone $this;
        $self['query'] = $query;

        return $self;
    }

    /**
     * Account username for this detailed monitor event.
     */
    public function withUsername(string $username): self
    {
        $self = clone $this;
        $self['username'] = $username;

        return $self;
    }

    public function withXEventID(string $xEventID): self
    {
        $self = clone $this;
        $self['xEventID'] = $xEventID;

        return $self;
    }
}
