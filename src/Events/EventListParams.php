<?php

declare(strict_types=1);

namespace XTwitterScraper\Events;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Events\EventListParams\EventType;

/**
 * List events.
 *
 * @see XTwitterScraper\Services\EventsService::list()
 *
 * @phpstan-type EventListParamsShape = array{
 *   after?: string|null,
 *   eventType?: null|EventType|value-of<EventType>,
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
     * Cursor for pagination.
     */
    #[Optional]
    public ?string $after;

    /** @var value-of<EventType>|null $eventType */
    #[Optional(enum: EventType::class)]
    public ?string $eventType;

    #[Optional]
    public ?int $limit;

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
        ?string $after = null,
        EventType|string|null $eventType = null,
        ?int $limit = null,
        ?string $monitorID = null,
    ): self {
        $self = new self;

        null !== $after && $self['after'] = $after;
        null !== $eventType && $self['eventType'] = $eventType;
        null !== $limit && $self['limit'] = $limit;
        null !== $monitorID && $self['monitorID'] = $monitorID;

        return $self;
    }

    /**
     * Cursor for pagination.
     */
    public function withAfter(string $after): self
    {
        $self = clone $this;
        $self['after'] = $after;

        return $self;
    }

    /**
     * @param EventType|value-of<EventType> $eventType
     */
    public function withEventType(EventType|string $eventType): self
    {
        $self = clone $this;
        $self['eventType'] = $eventType;

        return $self;
    }

    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    public function withMonitorID(string $monitorID): self
    {
        $self = clone $this;
        $self['monitorID'] = $monitorID;

        return $self;
    }
}
