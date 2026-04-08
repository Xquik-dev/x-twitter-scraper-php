<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Accounts;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Re-authenticate X account.
 *
 * @see XTwitterScraper\Services\X\AccountsService::reauth()
 *
 * @phpstan-type AccountReauthParamsShape = array{
 *   password: string, totpSecret?: string|null
 * }
 */
final class AccountReauthParams implements BaseModel
{
    /** @use SdkModel<AccountReauthParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Updated account password.
     */
    #[Required]
    public string $password;

    /**
     * TOTP secret for 2FA re-authentication.
     */
    #[Optional('totp_secret')]
    public ?string $totpSecret;

    /**
     * `new AccountReauthParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AccountReauthParams::with(password: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AccountReauthParams)->withPassword(...)
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
        string $password,
        ?string $totpSecret = null
    ): self {
        $self = new self;

        $self['password'] = $password;

        null !== $totpSecret && $self['totpSecret'] = $totpSecret;

        return $self;
    }

    /**
     * Updated account password.
     */
    public function withPassword(string $password): self
    {
        $self = clone $this;
        $self['password'] = $password;

        return $self;
    }

    /**
     * TOTP secret for 2FA re-authentication.
     */
    public function withTotpSecret(string $totpSecret): self
    {
        $self = clone $this;
        $self['totpSecret'] = $totpSecret;

        return $self;
    }
}
