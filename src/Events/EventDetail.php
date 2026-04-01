<?php

declare(strict_types=1);

namespace XTwitterScraper\Events;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Events\EventDetail\Type;

/**
 * @phpstan-type EventDetailShape = array{
 *   id: string,
 *   data: array<string,mixed>,
 *   monitorID: string,
 *   occurredAt: \DateTimeInterface,
 *   type: Type|value-of<Type>,
 *   username: string,
 *   xEventID?: string|null,
 * }
 */
final class EventDetail implements BaseModel
{
    /** @use SdkModel<EventDetailShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /** @var array<string,mixed> $data */
    #[Required(map: 'mixed')]
    public array $data;

    #[Required('monitorId')]
    public string $monitorID;

    #[Required]
    public \DateTimeInterface $occurredAt;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    #[Required]
    public string $username;

    #[Optional('xEventId')]
    public ?string $xEventID;

    /**
     * `new EventDetail()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * EventDetail::with(
     *   id: ..., data: ..., monitorID: ..., occurredAt: ..., type: ..., username: ...
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
     *   ->withOccurredAt(...)
     *   ->withType(...)
     *   ->withUsername(...)
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
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $id,
        array $data,
        string $monitorID,
        \DateTimeInterface $occurredAt,
        Type|string $type,
        string $username,
        ?string $xEventID = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['data'] = $data;
        $self['monitorID'] = $monitorID;
        $self['occurredAt'] = $occurredAt;
        $self['type'] = $type;
        $self['username'] = $username;

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
     * @param array<string,mixed> $data
     */
    public function withData(array $data): self
    {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }

    public function withMonitorID(string $monitorID): self
    {
        $self = clone $this;
        $self['monitorID'] = $monitorID;

        return $self;
    }

    public function withOccurredAt(\DateTimeInterface $occurredAt): self
    {
        $self = clone $this;
        $self['occurredAt'] = $occurredAt;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

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
