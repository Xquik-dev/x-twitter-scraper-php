<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Accounts;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Connect X account.
 *
 * @see XTwitterScraper\Services\X\AccountsService::create()
 *
 * @phpstan-type AccountCreateParamsShape = array{
 *   email: string,
 *   password: string,
 *   username: string,
 *   proxyCountry?: string|null,
 *   totpSecret?: string|null,
 * }
 */
final class AccountCreateParams implements BaseModel
{
    /** @use SdkModel<AccountCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Account email.
     */
    #[Required]
    public string $email;

    /**
     * Account password.
     */
    #[Required]
    public string $password;

    /**
     * X username.
     */
    #[Required]
    public string $username;

    /**
     * Proxy country code.
     */
    #[Optional('proxy_country')]
    public ?string $proxyCountry;

    /**
     * TOTP secret for 2FA.
     */
    #[Optional('totp_secret')]
    public ?string $totpSecret;

    /**
     * `new AccountCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AccountCreateParams::with(email: ..., password: ..., username: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AccountCreateParams)->withEmail(...)->withPassword(...)->withUsername(...)
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
        string $email,
        string $password,
        string $username,
        ?string $proxyCountry = null,
        ?string $totpSecret = null,
    ): self {
        $self = new self;

        $self['email'] = $email;
        $self['password'] = $password;
        $self['username'] = $username;

        null !== $proxyCountry && $self['proxyCountry'] = $proxyCountry;
        null !== $totpSecret && $self['totpSecret'] = $totpSecret;

        return $self;
    }

    /**
     * Account email.
     */
    public function withEmail(string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    /**
     * Account password.
     */
    public function withPassword(string $password): self
    {
        $self = clone $this;
        $self['password'] = $password;

        return $self;
    }

    /**
     * X username.
     */
    public function withUsername(string $username): self
    {
        $self = clone $this;
        $self['username'] = $username;

        return $self;
    }

    /**
     * Proxy country code.
     */
    public function withProxyCountry(string $proxyCountry): self
    {
        $self = clone $this;
        $self['proxyCountry'] = $proxyCountry;

        return $self;
    }

    /**
     * TOTP secret for 2FA.
     */
    public function withTotpSecret(string $totpSecret): self
    {
        $self = clone $this;
        $self['totpSecret'] = $totpSecret;

        return $self;
    }
}
