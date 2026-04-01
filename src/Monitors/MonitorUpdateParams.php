<?php

declare(strict_types=1);

namespace XTwitterScraper\Monitors;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Monitors\MonitorUpdateParams\EventType;

/**
 * Update monitor.
 *
 * @see XTwitterScraper\Services\MonitorsService::update()
 *
 * @phpstan-type MonitorUpdateParamsShape = array{
 *   eventTypes?: list<EventType|value-of<EventType>>|null, isActive?: bool|null
 * }
 */
final class MonitorUpdateParams implements BaseModel
{
    /** @use SdkModel<MonitorUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /** @var list<value-of<EventType>>|null $eventTypes */
    #[Optional(list: EventType::class)]
    public ?array $eventTypes;

    #[Optional]
    public ?bool $isActive;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<EventType|value-of<EventType>>|null $eventTypes
     */
    public static function with(
        ?array $eventTypes = null,
        ?bool $isActive = null
    ): self {
        $self = new self;

        null !== $eventTypes && $self['eventTypes'] = $eventTypes;
        null !== $isActive && $self['isActive'] = $isActive;

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

    public function withIsActive(bool $isActive): self
    {
        $self = clone $this;
        $self['isActive'] = $isActive;

        return $self;
    }
}
