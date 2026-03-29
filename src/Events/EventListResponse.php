<?php

declare(strict_types=1);

namespace XTwitterScraper\Events;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Events\EventListResponse\Event;

/**
 * @phpstan-import-type EventShape from \XTwitterScraper\Events\EventListResponse\Event
 *
 * @phpstan-type EventListResponseShape = array{
 *   events: list<Event|EventShape>, hasMore: bool, nextCursor?: string|null
 * }
 */
final class EventListResponse implements BaseModel
{
    /** @use SdkModel<EventListResponseShape> */
    use SdkModel;

    /** @var list<Event> $events */
    #[Required(list: Event::class)]
    public array $events;

    #[Required]
    public bool $hasMore;

    #[Optional]
    public ?string $nextCursor;

    /**
     * `new EventListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * EventListResponse::with(events: ..., hasMore: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new EventListResponse)->withEvents(...)->withHasMore(...)
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
     * @param list<Event|EventShape> $events
     */
    public static function with(
        array $events,
        bool $hasMore,
        ?string $nextCursor = null
    ): self {
        $self = new self;

        $self['events'] = $events;
        $self['hasMore'] = $hasMore;

        null !== $nextCursor && $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * @param list<Event|EventShape> $events
     */
    public function withEvents(array $events): self
    {
        $self = clone $this;
        $self['events'] = $events;

        return $self;
    }

    public function withHasMore(bool $hasMore): self
    {
        $self = clone $this;
        $self['hasMore'] = $hasMore;

        return $self;
    }

    public function withNextCursor(string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }
}
