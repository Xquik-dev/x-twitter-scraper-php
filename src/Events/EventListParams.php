<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Events;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\EventType;

/**
 * List events.
 *
 * @see XTwitterScraper\Services\EventsService::list()
 *
 * @phpstan-type EventListParamsShape = array{
 *   cursor?: string|null,
 *   eventType?: null|EventType|value-of<EventType>,
 *   keywordMonitorID?: string|null,
 *   limit?: int|null,
 *   monitorID?: string|null,
 * }
 */
final class EventListParams implements BaseModel
{
    /** @use SdkModel<EventListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Previous nextCursor.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Filter events by type.
     *
     * @var value-of<EventType>|null $eventType
     */
    #[Optional(enum: EventType::class)]
    public ?string $eventType;

    /**
     * Keyword monitor ID.
     */
    #[Optional]
    public ?string $keywordMonitorID;

    /**
     * Maximum number of items to return (1-100, default 50). For paid per-result endpoints, the returned count may be lower when remaining credits cannot cover the requested page. If zero paid results are affordable, the endpoint returns 402 insufficient_credits.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Account monitor ID.
     */
    #[Optional]
    public ?string $monitorID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param EventType|value-of<EventType>|null $eventType
     */
    public static function with(
        ?string $cursor = null,
        EventType|string|null $eventType = null,
        ?string $keywordMonitorID = null,
        ?int $limit = null,
        ?string $monitorID = null,
    ): self {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $eventType && $self['eventType'] = $eventType;
        null !== $keywordMonitorID && $self['keywordMonitorID'] = $keywordMonitorID;
        null !== $limit && $self['limit'] = $limit;
        null !== $monitorID && $self['monitorID'] = $monitorID;

        return $self;
    }

    /**
     * Previous nextCursor.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Filter events by type.
     *
     * @param EventType|value-of<EventType> $eventType
     */
    public function withEventType(EventType|string $eventType): self
    {
        $self = clone $this;
        $self['eventType'] = $eventType;

        return $self;
    }

    /**
     * Keyword monitor ID.
     */
    public function withKeywordMonitorID(string $keywordMonitorID): self
    {
        $self = clone $this;
        $self['keywordMonitorID'] = $keywordMonitorID;

        return $self;
    }

    /**
     * Maximum number of items to return (1-100, default 50). For paid per-result endpoints, the returned count may be lower when remaining credits cannot cover the requested page. If zero paid results are affordable, the endpoint returns 402 insufficient_credits.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Account monitor ID.
     */
    public function withMonitorID(string $monitorID): self
    {
        $self = clone $this;
        $self['monitorID'] = $monitorID;

        return $self;
    }
}
