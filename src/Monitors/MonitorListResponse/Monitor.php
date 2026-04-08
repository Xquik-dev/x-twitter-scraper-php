<?php

declare(strict_types=1);

namespace XTwitterScraper\Monitors\MonitorListResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Monitors\MonitorListResponse\Monitor\EventType;

/**
 * Account monitor that tracks activity for a given X user.
 *
 * @phpstan-type MonitorShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   eventTypes: list<EventType|value-of<EventType>>,
 *   isActive: bool,
 *   username: string,
 *   xUserID: string,
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

    #[Required]
    public string $username;

    #[Required('xUserId')]
    public string $xUserID;

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
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        array $eventTypes,
        bool $isActive,
        string $username,
        string $xUserID,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['eventTypes'] = $eventTypes;
        $self['isActive'] = $isActive;
        $self['username'] = $username;
        $self['xUserID'] = $xUserID;

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
}
