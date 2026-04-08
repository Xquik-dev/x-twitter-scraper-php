<?php

declare(strict_types=1);

namespace XTwitterScraper\APIKeys;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type APIKeyShape from \XTwitterScraper\APIKeys\APIKey
 *
 * @phpstan-type APIKeyListResponseShape = array{keys: list<APIKey|APIKeyShape>}
 */
final class APIKeyListResponse implements BaseModel
{
    /** @use SdkModel<APIKeyListResponseShape> */
    use SdkModel;

    /** @var list<APIKey> $keys */
    #[Required(list: APIKey::class)]
    public array $keys;

    /**
     * `new APIKeyListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * APIKeyListResponse::with(keys: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new APIKeyListResponse)->withKeys(...)
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
     * @param list<APIKey|APIKeyShape> $keys
     */
    public static function with(array $keys): self
    {
        $self = new self;

        $self['keys'] = $keys;

        return $self;
    }

    /**
     * @param list<APIKey|APIKeyShape> $keys
     */
    public function withKeys(array $keys): self
    {
        $self = clone $this;
        $self['keys'] = $keys;

        return $self;
    }
}
