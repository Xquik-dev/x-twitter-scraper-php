<?php

declare(strict_types=1);

namespace XTwitterScraper\APIKeys;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type APIKeyNewResponseShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   fullKey: string,
 *   name: string,
 *   prefix: string,
 * }
 */
final class APIKeyNewResponse implements BaseModel
{
    /** @use SdkModel<APIKeyNewResponseShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public string $fullKey;

    #[Required]
    public string $name;

    #[Required]
    public string $prefix;

    /**
     * `new APIKeyNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * APIKeyNewResponse::with(
     *   id: ..., createdAt: ..., fullKey: ..., name: ..., prefix: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new APIKeyNewResponse)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withFullKey(...)
     *   ->withName(...)
     *   ->withPrefix(...)
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
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        string $fullKey,
        string $name,
        string $prefix,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['fullKey'] = $fullKey;
        $self['name'] = $name;
        $self['prefix'] = $prefix;

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

    public function withFullKey(string $fullKey): self
    {
        $self = clone $this;
        $self['fullKey'] = $fullKey;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withPrefix(string $prefix): self
    {
        $self = clone $this;
        $self['prefix'] = $prefix;

        return $self;
    }
}
