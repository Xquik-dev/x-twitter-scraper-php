<?php

declare(strict_types=1);

namespace XTwitterScraper\APIKeys\APIKeyListResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * API key metadata returned when listing keys.
 *
 * @phpstan-type KeyShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   isActive: bool,
 *   name: string,
 *   prefix: string,
 *   lastUsedAt?: \DateTimeInterface|null,
 * }
 */
final class Key implements BaseModel
{
    /** @use SdkModel<KeyShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public bool $isActive;

    #[Required]
    public string $name;

    #[Required]
    public string $prefix;

    #[Optional]
    public ?\DateTimeInterface $lastUsedAt;

    /**
     * `new Key()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Key::with(id: ..., createdAt: ..., isActive: ..., name: ..., prefix: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Key)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withIsActive(...)
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
        bool $isActive,
        string $name,
        string $prefix,
        ?\DateTimeInterface $lastUsedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['isActive'] = $isActive;
        $self['name'] = $name;
        $self['prefix'] = $prefix;

        null !== $lastUsedAt && $self['lastUsedAt'] = $lastUsedAt;

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

    public function withPrefix(string $prefix): self
    {
        $self = clone $this;
        $self['prefix'] = $prefix;

        return $self;
    }

    public function withLastUsedAt(\DateTimeInterface $lastUsedAt): self
    {
        $self = clone $this;
        $self['lastUsedAt'] = $lastUsedAt;

        return $self;
    }
}
