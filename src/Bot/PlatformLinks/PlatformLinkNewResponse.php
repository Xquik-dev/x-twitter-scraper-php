<?php

declare(strict_types=1);

namespace XTwitterScraper\Bot\PlatformLinks;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type PlatformLinkNewResponseShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   platform: string,
 *   platformUserID: string,
 * }
 */
final class PlatformLinkNewResponse implements BaseModel
{
    /** @use SdkModel<PlatformLinkNewResponseShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public string $platform;

    #[Required('platformUserId')]
    public string $platformUserID;

    /**
     * `new PlatformLinkNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PlatformLinkNewResponse::with(
     *   id: ..., createdAt: ..., platform: ..., platformUserID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PlatformLinkNewResponse)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withPlatform(...)
     *   ->withPlatformUserID(...)
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
        string $platform,
        string $platformUserID,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['platform'] = $platform;
        $self['platformUserID'] = $platformUserID;

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

    public function withPlatform(string $platform): self
    {
        $self = clone $this;
        $self['platform'] = $platform;

        return $self;
    }

    public function withPlatformUserID(string $platformUserID): self
    {
        $self = clone $this;
        $self['platformUserID'] = $platformUserID;

        return $self;
    }
}
