<?php

declare(strict_types=1);

namespace XTwitterScraper\SearchTweet;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Public card metadata attached to a tweet.
 *
 * @phpstan-type CardShape = array{
 *   id?: string|null,
 *   bindingValues?: array<string,mixed>|null,
 *   name?: string|null,
 *   url?: string|null,
 * }
 */
final class Card implements BaseModel
{
    /** @use SdkModel<CardShape> */
    use SdkModel;

    #[Optional]
    public ?string $id;

    /** @var array<string,mixed>|null $bindingValues */
    #[Optional(map: 'mixed')]
    public ?array $bindingValues;

    #[Optional]
    public ?string $name;

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
     * @param array<string,mixed>|null $bindingValues
     */
    public static function with(
        ?string $id = null,
        ?array $bindingValues = null,
        ?string $name = null,
        ?string $url = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $bindingValues && $self['bindingValues'] = $bindingValues;
        null !== $name && $self['name'] = $name;
        null !== $url && $self['url'] = $url;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param array<string,mixed> $bindingValues
     */
    public function withBindingValues(array $bindingValues): self
    {
        $self = clone $this;
        $self['bindingValues'] = $bindingValues;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
