<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Accounts;

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
 *   email: string, password: string, totpSecret: string, username: string
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
     * Authenticator App TOTP secret required for durable login.
     */
    #[Required('totp_secret')]
    public string $totpSecret;

    /**
     * X username.
     */
    #[Required]
    public string $username;

    /**
     * `new AccountCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AccountCreateParams::with(
     *   email: ..., password: ..., totpSecret: ..., username: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AccountCreateParams)
     *   ->withEmail(...)
     *   ->withPassword(...)
     *   ->withTotpSecret(...)
     *   ->withUsername(...)
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
        string $totpSecret,
        string $username
    ): self {
        $self = new self;

        $self['email'] = $email;
        $self['password'] = $password;
        $self['totpSecret'] = $totpSecret;
        $self['username'] = $username;

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
     * Authenticator App TOTP secret required for durable login.
     */
    public function withTotpSecret(string $totpSecret): self
    {
        $self = clone $this;
        $self['totpSecret'] = $totpSecret;

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
}
