<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Accounts;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Accounts\AccountReauthResponse\Health;

/**
 * Sanitized X account summary returned by connect and reauth. Includes an optional `loginCountry` field surfaced only when the declared proxy region had no Driver capacity and the login fell back to a single US consumer device for this one-time action. Future activity continues to use the selected `proxy_country`; the field is omitted on normal logins.
 *
 * @phpstan-type AccountReauthResponseShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   health: Health|value-of<Health>,
 *   status: string,
 *   xUserID: string,
 *   xUsername: string,
 *   loginCountry?: string|null,
 * }
 */
final class AccountReauthResponse implements BaseModel
{
    /** @use SdkModel<AccountReauthResponseShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    /** @var value-of<Health> $health */
    #[Required(enum: Health::class)]
    public string $health;

    #[Required]
    public string $status;

    #[Required('xUserId')]
    public string $xUserID;

    #[Required]
    public string $xUsername;

    /**
     * ISO-3166-1 alpha-2 country code of the Driver consumer device used for this login. Present only when the US fallback was triggered because Driver had no capacity in the declared region. Omitted otherwise.
     */
    #[Optional]
    public ?string $loginCountry;

    /**
     * `new AccountReauthResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AccountReauthResponse::with(
     *   id: ...,
     *   createdAt: ...,
     *   health: ...,
     *   status: ...,
     *   xUserID: ...,
     *   xUsername: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AccountReauthResponse)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withHealth(...)
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
     *
     * @param Health|value-of<Health> $health
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        Health|string $health,
        string $status,
        string $xUserID,
        string $xUsername,
        ?string $loginCountry = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['health'] = $health;
        $self['status'] = $status;
        $self['xUserID'] = $xUserID;
        $self['xUsername'] = $xUsername;

        null !== $loginCountry && $self['loginCountry'] = $loginCountry;

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

    /**
     * @param Health|value-of<Health> $health
     */
    public function withHealth(Health|string $health): self
    {
        $self = clone $this;
        $self['health'] = $health;

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

    /**
     * ISO-3166-1 alpha-2 country code of the Driver consumer device used for this login. Present only when the US fallback was triggered because Driver had no capacity in the declared region. Omitted otherwise.
     */
    public function withLoginCountry(string $loginCountry): self
    {
        $self = clone $this;
        $self['loginCountry'] = $loginCountry;

        return $self;
    }
}
