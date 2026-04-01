<?php

declare(strict_types=1);

namespace XTwitterScraper\Integrations;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Integrations\IntegrationCreateParams\Config;
use XTwitterScraper\Integrations\IntegrationCreateParams\EventType;
use XTwitterScraper\Integrations\IntegrationCreateParams\Type;

/**
 * Create integration.
 *
 * @see XTwitterScraper\Services\IntegrationsService::create()
 *
 * @phpstan-import-type ConfigShape from \XTwitterScraper\Integrations\IntegrationCreateParams\Config
 *
 * @phpstan-type IntegrationCreateParamsShape = array{
 *   config: Config|ConfigShape,
 *   eventTypes: list<EventType|value-of<EventType>>,
 *   name: string,
 *   type: Type|value-of<Type>,
 * }
 */
final class IntegrationCreateParams implements BaseModel
{
    /** @use SdkModel<IntegrationCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Integration config (e.g. Telegram chatId).
     */
    #[Required]
    public Config $config;

    /** @var list<value-of<EventType>> $eventTypes */
    #[Required(list: EventType::class)]
    public array $eventTypes;

    #[Required]
    public string $name;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new IntegrationCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * IntegrationCreateParams::with(
     *   config: ..., eventTypes: ..., name: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new IntegrationCreateParams)
     *   ->withConfig(...)
     *   ->withEventTypes(...)
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
     * @param Config|ConfigShape $config
     * @param list<EventType|value-of<EventType>> $eventTypes
     * @param Type|value-of<Type> $type
     */
    public static function with(
        Config|array $config,
        array $eventTypes,
        string $name,
        Type|string $type
    ): self {
        $self = new self;

        $self['config'] = $config;
        $self['eventTypes'] = $eventTypes;
        $self['name'] = $name;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Integration config (e.g. Telegram chatId).
     *
     * @param Config|ConfigShape $config
     */
    public function withConfig(Config|array $config): self
    {
        $self = clone $this;
        $self['config'] = $config;

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
}
