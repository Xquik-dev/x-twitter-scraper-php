<?php

declare(strict_types=1);

namespace XTwitterScraper\Credits;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CreditGetBalanceResponseShape = array{
 *   autoTopupEnabled: bool,
 *   balance: int,
 *   lifetimePurchased: int,
 *   lifetimeUsed: int,
 * }
 */
final class CreditGetBalanceResponse implements BaseModel
{
    /** @use SdkModel<CreditGetBalanceResponseShape> */
    use SdkModel;

    #[Required('auto_topup_enabled')]
    public bool $autoTopupEnabled;

    #[Required]
    public int $balance;

    #[Required('lifetime_purchased')]
    public int $lifetimePurchased;

    #[Required('lifetime_used')]
    public int $lifetimeUsed;

    /**
     * `new CreditGetBalanceResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CreditGetBalanceResponse::with(
     *   autoTopupEnabled: ..., balance: ..., lifetimePurchased: ..., lifetimeUsed: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CreditGetBalanceResponse)
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
