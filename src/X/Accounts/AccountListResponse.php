<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Accounts;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type XAccountShape from \XTwitterScraper\X\Accounts\XAccount
 *
 * @phpstan-type AccountListResponseShape = array{
 *   accounts: list<XAccount|XAccountShape>
 * }
 */
final class AccountListResponse implements BaseModel
{
    /** @use SdkModel<AccountListResponseShape> */
    use SdkModel;

    /** @var list<XAccount> $accounts */
    #[Required(list: XAccount::class)]
    public array $accounts;

    /**
     * `new AccountListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AccountListResponse::with(accounts: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AccountListResponse)->withAccounts(...)
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
     * @param list<XAccount|XAccountShape> $accounts
     */
    public static function with(array $accounts): self
    {
        $self = new self;

        $self['accounts'] = $accounts;

        return $self;
    }

    /**
     * @param list<XAccount|XAccountShape> $accounts
     */
    public function withAccounts(array $accounts): self
    {
        $self = clone $this;
        $self['accounts'] = $accounts;

        return $self;
    }
}
