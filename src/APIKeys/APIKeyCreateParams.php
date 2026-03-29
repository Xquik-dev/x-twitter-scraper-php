<?php

declare(strict_types=1);

namespace XTwitterScraper\APIKeys;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Create API key.
 *
 * @see XTwitterScraper\Services\APIKeysService::create()
 *
 * @phpstan-type APIKeyCreateParamsShape = array{name?: string|null}
 */
final class APIKeyCreateParams implements BaseModel
{
    /** @use SdkModel<APIKeyCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?string $name;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $name = null): self
    {
        $self = new self;

        null !== $name && $self['name'] = $name;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
