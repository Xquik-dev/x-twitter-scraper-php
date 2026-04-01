<?php

declare(strict_types=1);

namespace XTwitterScraper\Monitors;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Monitors\MonitorCreateParams\EventType;

/**
 * Create monitor.
 *
 * @see XTwitterScraper\Services\MonitorsService::create()
 *
 * @phpstan-type MonitorCreateParamsShape = array{
 *   eventTypes: list<EventType|value-of<EventType>>, username: string
 * }
 */
final class MonitorCreateParams implements BaseModel
{
    /** @use SdkModel<MonitorCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /** @var list<value-of<EventType>> $eventTypes */
    #[Required(list: EventType::class)]
    public array $eventTypes;

    /**
     * X username (without @).
     */
    #[Required]
    public string $username;

    /**
     * `new MonitorCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MonitorCreateParams::with(eventTypes: ..., username: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MonitorCreateParams)->withEventTypes(...)->withUsername(...)
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
    public static function with(array $eventTypes, string $username): self
    {
        $self = new self;

        $self['eventTypes'] = $eventTypes;
        $self['username'] = $username;

        return $self;
    }

    /**
     * @param list<EventType|value-of<EventType>> $eventTypes
     */
    public function withEventTypes(array $eventTypes): self
    {
        $self = clone $this;
        $self['eventTypes'] = $eventTypes;

        return $self;
    }

    /**
     * X username (without @).
     */
    public function withUsername(string $username): self
    {
        $self = clone $this;
        $self['username'] = $username;

        return $self;
    }
}
