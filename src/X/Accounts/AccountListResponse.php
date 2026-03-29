<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Accounts;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Accounts\AccountListResponse\Account;

/**
 * @phpstan-import-type AccountShape from \XTwitterScraper\X\Accounts\AccountListResponse\Account
 *
 * @phpstan-type AccountListResponseShape = array{
 *   accounts: list<Account|AccountShape>
 * }
 */
final class AccountListResponse implements BaseModel
{
    /** @use SdkModel<AccountListResponseShape> */
    use SdkModel;

    /** @var list<Account> $accounts */
    #[Required(list: Account::class)]
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
     * @param list<Account|AccountShape> $accounts
     */
    public static function with(array $accounts): self
    {
        $self = new self;

        $self['accounts'] = $accounts;

        return $self;
    }

    /**
     * @param list<Account|AccountShape> $accounts
     */
    public function withAccounts(array $accounts): self
    {
        $self = clone $this;
        $self['accounts'] = $accounts;

        return $self;
    }
}
