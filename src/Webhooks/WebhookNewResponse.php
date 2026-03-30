<?php

declare(strict_types=1);

namespace XTwitterScraper\Webhooks;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\EventType;

/**
 * @phpstan-type WebhookNewResponseShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   eventTypes: list<EventType|value-of<EventType>>,
 *   secret: string,
 *   url: string,
 * }
 */
final class WebhookNewResponse implements BaseModel
{
    /** @use SdkModel<WebhookNewResponseShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    /** @var list<value-of<EventType>> $eventTypes */
    #[Required(list: EventType::class)]
    public array $eventTypes;

    #[Required]
    public string $secret;

    #[Required]
    public string $url;

    /**
     * `new WebhookNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebhookNewResponse::with(
     *   id: ..., createdAt: ..., eventTypes: ..., secret: ..., url: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebhookNewResponse)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withEventTypes(...)
     *   ->withSecret(...)
     *   ->withURL(...)
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
        string $secret,
        string $url,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['eventTypes'] = $eventTypes;
        $self['secret'] = $secret;
        $self['url'] = $url;

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
     * @param list<EventType|value-of<EventType>> $eventTypes
     */
    public function withEventTypes(array $eventTypes): self
    {
        $self = clone $this;
        $self['eventTypes'] = $eventTypes;

        return $self;
    }

    public function withSecret(string $secret): self
    {
        $self = clone $this;
        $self['secret'] = $secret;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
