<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Accounts;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type AccountGetResponseShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   status: string,
 *   xUserID: string,
 *   xUsername: string,
 *   cookiesObtainedAt?: \DateTimeInterface|null,
 *   proxyCountry?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class AccountGetResponse implements BaseModel
{
    /** @use SdkModel<AccountGetResponseShape> */
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

    #[Optional]
    public ?\DateTimeInterface $cookiesObtainedAt;

    #[Optional]
    public ?string $proxyCountry;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * `new AccountGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AccountGetResponse::with(
     *   id: ..., createdAt: ..., status: ..., xUserID: ..., xUsername: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AccountGetResponse)
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
        ?\DateTimeInterface $cookiesObtainedAt = null,
        ?string $proxyCountry = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['status'] = $status;
        $self['xUserID'] = $xUserID;
        $self['xUsername'] = $xUsername;

        null !== $cookiesObtainedAt && $self['cookiesObtainedAt'] = $cookiesObtainedAt;
        null !== $proxyCountry && $self['proxyCountry'] = $proxyCountry;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

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

    public function withCookiesObtainedAt(
        \DateTimeInterface $cookiesObtainedAt
    ): self {
        $self = clone $this;
        $self['cookiesObtainedAt'] = $cookiesObtainedAt;

        return $self;
    }

    public function withProxyCountry(string $proxyCountry): self
    {
        $self = clone $this;
        $self['proxyCountry'] = $proxyCountry;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
