<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Accounts;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type AccountReauthResponseShape = array{
 *   id: string, status: string, xUsername: string
 * }
 */
final class AccountReauthResponse implements BaseModel
{
    /** @use SdkModel<AccountReauthResponseShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $status;

    #[Required]
    public string $xUsername;

    /**
     * `new AccountReauthResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AccountReauthResponse::with(id: ..., status: ..., xUsername: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AccountReauthResponse)->withID(...)->withStatus(...)->withXUsername(...)
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
        string $status,
        string $xUsername
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['status'] = $status;
        $self['xUsername'] = $xUsername;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withXUsername(string $xUsername): self
    {
        $self = clone $this;
        $self['xUsername'] = $xUsername;

        return $self;
    }
}
