<?php

declare(strict_types=1);

namespace XTwitterScraper\Account\AccountGetResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CreditInfoShape = array{
 *   autoTopupEnabled: bool,
 *   balance: int,
 *   lifetimePurchased: int,
 *   lifetimeUsed: int,
 * }
 */
final class CreditInfo implements BaseModel
{
    /** @use SdkModel<CreditInfoShape> */
    use SdkModel;

    #[Required]
    public bool $autoTopupEnabled;

    #[Required]
    public int $balance;

    #[Required]
    public int $lifetimePurchased;

    #[Required]
    public int $lifetimeUsed;

    /**
     * `new CreditInfo()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CreditInfo::with(
     *   autoTopupEnabled: ..., balance: ..., lifetimePurchased: ..., lifetimeUsed: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CreditInfo)
     *   ->withAutoTopupEnabled(...)
     *   ->withBalance(...)
     *   ->withLifetimePurchased(...)
     *   ->withLifetimeUsed(...)
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
        bool $autoTopupEnabled,
        int $balance,
        int $lifetimePurchased,
        int $lifetimeUsed,
    ): self {
        $self = new self;

        $self['autoTopupEnabled'] = $autoTopupEnabled;
        $self['balance'] = $balance;
        $self['lifetimePurchased'] = $lifetimePurchased;
        $self['lifetimeUsed'] = $lifetimeUsed;

        return $self;
    }

    public function withAutoTopupEnabled(bool $autoTopupEnabled): self
    {
        $self = clone $this;
        $self['autoTopupEnabled'] = $autoTopupEnabled;

        return $self;
    }

    public function withBalance(int $balance): self
    {
        $self = clone $this;
        $self['balance'] = $balance;

        return $self;
    }

    public function withLifetimePurchased(int $lifetimePurchased): self
    {
        $self = clone $this;
        $self['lifetimePurchased'] = $lifetimePurchased;

        return $self;
    }

    public function withLifetimeUsed(int $lifetimeUsed): self
    {
        $self = clone $this;
        $self['lifetimeUsed'] = $lifetimeUsed;

        return $self;
    }
}
