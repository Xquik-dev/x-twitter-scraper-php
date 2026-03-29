<?php

declare(strict_types=1);

namespace XTwitterScraper\Account;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Set linked X username.
 *
 * @see XTwitterScraper\Services\AccountService::setXUsername()
 *
 * @phpstan-type AccountSetXUsernameParamsShape = array{username: string}
 */
final class AccountSetXUsernameParams implements BaseModel
{
    /** @use SdkModel<AccountSetXUsernameParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * X username without @.
     */
    #[Required]
    public string $username;

    /**
     * `new AccountSetXUsernameParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AccountSetXUsernameParams::with(username: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AccountSetXUsernameParams)->withUsername(...)
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
    public static function with(string $username): self
    {
        $self = new self;

        $self['username'] = $username;

        return $self;
    }

    /**
     * X username without @.
     */
    public function withUsername(string $username): self
    {
        $self = clone $this;
        $self['username'] = $username;

        return $self;
    }
}
