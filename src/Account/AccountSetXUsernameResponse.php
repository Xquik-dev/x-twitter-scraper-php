<?php

declare(strict_types=1);

namespace XTwitterScraper\Account;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type AccountSetXUsernameResponseShape = array{
 *   success: bool, xUsername: string
 * }
 */
final class AccountSetXUsernameResponse implements BaseModel
{
    /** @use SdkModel<AccountSetXUsernameResponseShape> */
    use SdkModel;

    #[Required]
    public bool $success = true;

    #[Required]
    public string $xUsername;

    /**
     * `new AccountSetXUsernameResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AccountSetXUsernameResponse::with(xUsername: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AccountSetXUsernameResponse)->withXUsername(...)
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
    public static function with(string $xUsername): self
    {
        $self = new self;

        $self['xUsername'] = $xUsername;

        return $self;
    }

    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }

    public function withXUsername(string $xUsername): self
    {
        $self = clone $this;
        $self['xUsername'] = $xUsername;

        return $self;
    }
}
