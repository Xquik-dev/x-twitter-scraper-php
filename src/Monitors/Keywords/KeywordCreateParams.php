<?php

declare(strict_types=1);

namespace XTwitterScraper\Monitors\Keywords;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\EventType;

/**
 * Creates a keyword monitor. Keyword monitors are unlimited. Active monitors check every 1 second and cost 21 credits per hour. Events and webhook deliveries are included. Creation requires available credits for the first hourly charge.
 *
 * @see XTwitterScraper\Services\Monitors\KeywordsService::create()
 *
 * @phpstan-type KeywordCreateParamsShape = array{
 *   eventTypes: list<EventType|value-of<EventType>>, query: string
 * }
 */
final class KeywordCreateParams implements BaseModel
{
    /** @use SdkModel<KeywordCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Array of event types to subscribe to.
     *
     * @var list<value-of<EventType>> $eventTypes
     */
    #[Required(list: EventType::class)]
    public array $eventTypes;

    /**
     * X search query to monitor. Whitespace is normalized.
     */
    #[Required]
    public string $query;

    /**
     * `new KeywordCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * KeywordCreateParams::with(eventTypes: ..., query: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new KeywordCreateParams)->withEventTypes(...)->withQuery(...)
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
     */
    public static function with(array $eventTypes, string $query): self
    {
        $self = new self;

        $self['eventTypes'] = $eventTypes;
        $self['query'] = $query;

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

    /**
     * X search query to monitor. Whitespace is normalized.
     */
    public function withQuery(string $query): self
    {
        $self = clone $this;
        $self['query'] = $query;

        return $self;
    }
}
