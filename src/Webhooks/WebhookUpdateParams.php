<?php

declare(strict_types=1);

namespace XTwitterScraper\Webhooks;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\EventType;

/**
 * Update webhook.
 *
 * @see XTwitterScraper\Services\WebhooksService::update()
 *
 * @phpstan-type WebhookUpdateParamsShape = array{
 *   eventTypes?: list<EventType|value-of<EventType>>|null,
 *   isActive?: bool|null,
 *   url?: string|null,
 * }
 */
final class WebhookUpdateParams implements BaseModel
{
    /** @use SdkModel<WebhookUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Array of event types to subscribe to.
     *
     * @var list<value-of<EventType>>|null $eventTypes
     */
    #[Optional(list: EventType::class)]
    public ?array $eventTypes;

    #[Optional]
    public ?bool $isActive;

    #[Optional]
    public ?string $url;

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
        ?bool $isActive = null,
        ?string $url = null
    ): self {
        $self = new self;

        null !== $eventTypes && $self['eventTypes'] = $eventTypes;
        null !== $isActive && $self['isActive'] = $isActive;
        null !== $url && $self['url'] = $url;

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

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
