<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Accounts;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type XAccountShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   status: string,
 *   xUserID: string,
 *   xUsername: string,
 * }
 */
final class XAccount implements BaseModel
{
    /** @use SdkModel<XAccountShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public string $status;

    #[Required('xUserId')]
    public string $xUserID;

    #[Required]
    public string $xUsername;

    /**
     * `new XAccount()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XAccount::with(
     *   id: ..., createdAt: ..., status: ..., xUserID: ..., xUsername: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XAccount)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withStatus(...)
     *   ->withXUserID(...)
     *   ->withXUsername(...)
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
        string $status,
        string $xUserID,
        string $xUsername,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['status'] = $status;
        $self['xUserID'] = $xUserID;
        $self['xUsername'] = $xUsername;

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

    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withXUserID(string $xUserID): self
    {
        $self = clone $this;
        $self['xUserID'] = $xUserID;

        return $self;
    }

    public function withXUsername(string $xUsername): self
    {
        $self = clone $this;
        $self['xUsername'] = $xUsername;

        return $self;
    }
}
