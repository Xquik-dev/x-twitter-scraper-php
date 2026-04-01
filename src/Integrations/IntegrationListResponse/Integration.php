<?php

declare(strict_types=1);

namespace XTwitterScraper\Integrations\IntegrationListResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Integrations\IntegrationListResponse\Integration\EventType;
use XTwitterScraper\Integrations\IntegrationListResponse\Integration\Type;

/**
 * @phpstan-type IntegrationShape = array{
 *   id: string,
 *   config: array<string,mixed>,
 *   createdAt: \DateTimeInterface,
 *   eventTypes: list<EventType|value-of<EventType>>,
 *   isActive: bool,
 *   name: string,
 *   type: Type|value-of<Type>,
 *   filters?: array<string,mixed>|null,
 *   messageTemplate?: string|null,
 *   scopeAllMonitors?: bool|null,
 *   silentPush?: bool|null,
 * }
 */
final class Integration implements BaseModel
{
    /** @use SdkModel<IntegrationShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /**
     * Integration config — shape varies by type (JSON).
     *
     * @var array<string,mixed> $config
     */
    #[Required(map: 'mixed')]
    public array $config;

    #[Required]
    public \DateTimeInterface $createdAt;

    /** @var list<value-of<EventType>> $eventTypes */
    #[Required(list: EventType::class)]
    public array $eventTypes;

    #[Required]
    public bool $isActive;

    #[Required]
    public string $name;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Event filter rules (JSON).
     *
     * @var array<string,mixed>|null $filters
     */
    #[Optional(map: 'mixed')]
    public ?array $filters;

    #[Optional]
    public ?string $messageTemplate;

    #[Optional]
    public ?bool $scopeAllMonitors;

    #[Optional]
    public ?bool $silentPush;

    /**
     * `new Integration()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Integration::with(
     *   id: ...,
     *   config: ...,
     *   createdAt: ...,
     *   eventTypes: ...,
     *   isActive: ...,
     *   name: ...,
     *   type: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Integration)
     *   ->withID(...)
     *   ->withConfig(...)
     *   ->withCreatedAt(...)
     *   ->withEventTypes(...)
     *   ->withIsActive(...)
     *   ->withName(...)
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
     * @param array<string,mixed> $config
     * @param list<EventType|value-of<EventType>> $eventTypes
     * @param Type|value-of<Type> $type
     * @param array<string,mixed>|null $filters
     */
    public static function with(
        string $id,
        array $config,
        \DateTimeInterface $createdAt,
        array $eventTypes,
        bool $isActive,
        string $name,
        Type|string $type,
        ?array $filters = null,
        ?string $messageTemplate = null,
        ?bool $scopeAllMonitors = null,
        ?bool $silentPush = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['config'] = $config;
        $self['createdAt'] = $createdAt;
        $self['eventTypes'] = $eventTypes;
        $self['isActive'] = $isActive;
        $self['name'] = $name;
        $self['type'] = $type;

        null !== $filters && $self['filters'] = $filters;
        null !== $messageTemplate && $self['messageTemplate'] = $messageTemplate;
        null !== $scopeAllMonitors && $self['scopeAllMonitors'] = $scopeAllMonitors;
        null !== $silentPush && $self['silentPush'] = $silentPush;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Integration config — shape varies by type (JSON).
     *
     * @param array<string,mixed> $config
     */
    public function withConfig(array $config): self
    {
        $self = clone $this;
        $self['config'] = $config;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

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

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

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

    /**
     * Event filter rules (JSON).
     *
     * @param array<string,mixed> $filters
     */
    public function withFilters(array $filters): self
    {
        $self = clone $this;
        $self['filters'] = $filters;

        return $self;
    }

    public function withMessageTemplate(string $messageTemplate): self
    {
        $self = clone $this;
        $self['messageTemplate'] = $messageTemplate;

        return $self;
    }

    public function withScopeAllMonitors(bool $scopeAllMonitors): self
    {
        $self = clone $this;
        $self['scopeAllMonitors'] = $scopeAllMonitors;

        return $self;
    }

    public function withSilentPush(bool $silentPush): self
    {
        $self = clone $this;
        $self['silentPush'] = $silentPush;

        return $self;
    }
}
