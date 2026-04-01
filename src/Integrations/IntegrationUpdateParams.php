<?php

declare(strict_types=1);

namespace XTwitterScraper\Integrations;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Integrations\IntegrationUpdateParams\EventType;

/**
 * Update integration.
 *
 * @see XTwitterScraper\Services\IntegrationsService::update()
 *
 * @phpstan-type IntegrationUpdateParamsShape = array{
 *   eventTypes?: list<EventType|value-of<EventType>>|null,
 *   filters?: array<string,mixed>|null,
 *   isActive?: bool|null,
 *   messageTemplate?: array<string,mixed>|null,
 *   name?: string|null,
 *   scopeAllMonitors?: bool|null,
 *   silentPush?: bool|null,
 * }
 */
final class IntegrationUpdateParams implements BaseModel
{
    /** @use SdkModel<IntegrationUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /** @var list<value-of<EventType>>|null $eventTypes */
    #[Optional(list: EventType::class)]
    public ?array $eventTypes;

    /**
     * Event filter rules (JSON).
     *
     * @var array<string,mixed>|null $filters
     */
    #[Optional(map: 'mixed')]
    public ?array $filters;

    #[Optional]
    public ?bool $isActive;

    /**
     * Custom message template (JSON).
     *
     * @var array<string,mixed>|null $messageTemplate
     */
    #[Optional(map: 'mixed')]
    public ?array $messageTemplate;

    #[Optional]
    public ?string $name;

    #[Optional]
    public ?bool $scopeAllMonitors;

    #[Optional]
    public ?bool $silentPush;

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
     * @param array<string,mixed>|null $filters
     * @param array<string,mixed>|null $messageTemplate
     */
    public static function with(
        ?array $eventTypes = null,
        ?array $filters = null,
        ?bool $isActive = null,
        ?array $messageTemplate = null,
        ?string $name = null,
        ?bool $scopeAllMonitors = null,
        ?bool $silentPush = null,
    ): self {
        $self = new self;

        null !== $eventTypes && $self['eventTypes'] = $eventTypes;
        null !== $filters && $self['filters'] = $filters;
        null !== $isActive && $self['isActive'] = $isActive;
        null !== $messageTemplate && $self['messageTemplate'] = $messageTemplate;
        null !== $name && $self['name'] = $name;
        null !== $scopeAllMonitors && $self['scopeAllMonitors'] = $scopeAllMonitors;
        null !== $silentPush && $self['silentPush'] = $silentPush;

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

    public function withIsActive(bool $isActive): self
    {
        $self = clone $this;
        $self['isActive'] = $isActive;

        return $self;
    }

    /**
     * Custom message template (JSON).
     *
     * @param array<string,mixed> $messageTemplate
     */
    public function withMessageTemplate(array $messageTemplate): self
    {
        $self = clone $this;
        $self['messageTemplate'] = $messageTemplate;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

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
