<?php

declare(strict_types=1);

namespace XTwitterScraper\APIKeys;

use XTwitterScraper\APIKeys\APIKeyListResponse\Key;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type KeyShape from \XTwitterScraper\APIKeys\APIKeyListResponse\Key
 *
 * @phpstan-type APIKeyListResponseShape = array{keys: list<Key|KeyShape>}
 */
final class APIKeyListResponse implements BaseModel
{
    /** @use SdkModel<APIKeyListResponseShape> */
    use SdkModel;

    /** @var list<Key> $keys */
    #[Required(list: Key::class)]
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
     * @param list<Key|KeyShape> $keys
     */
    public static function with(array $keys): self
    {
        $self = new self;

        $self['keys'] = $keys;

        return $self;
    }

    /**
     * @param list<Key|KeyShape> $keys
     */
    public function withKeys(array $keys): self
    {
        $self = clone $this;
        $self['keys'] = $keys;

        return $self;
    }
}
