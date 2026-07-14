<?php

declare(strict_types=1);

namespace XTwitterScraper\Credits;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CreditGetBalanceResponseShape = array{
 *   autoTopupAmountDollars: float,
 *   autoTopupEnabled: bool,
 *   autoTopupThreshold: string,
 *   balance: string,
 *   lifetimePurchased: string,
 *   lifetimeUsed: string,
 * }
 */
final class CreditGetBalanceResponse implements BaseModel
{
    /** @use SdkModel<CreditGetBalanceResponseShape> */
    use SdkModel;

    /**
     * Configured dollar amount for each automatic top-up.
     */
    #[Required('auto_topup_amount_dollars')]
    public float $autoTopupAmountDollars;

    #[Required('auto_topup_enabled')]
    public bool $autoTopupEnabled;

    /**
     * Credit balance threshold that triggers automatic top-up when enabled, represented as a bigint string.
     */
    #[Required('auto_topup_threshold')]
    public string $autoTopupThreshold;

    /**
     * Current credit balance as a bigint string to preserve precision above Number.MAX_SAFE_INTEGER.
     */
    #[Required]
    public string $balance;

    /**
     * Lifetime purchased credits as a bigint string.
     */
    #[Required('lifetime_purchased')]
    public string $lifetimePurchased;

    /**
     * Lifetime consumed credits as a bigint string.
     */
    #[Required('lifetime_used')]
    public string $lifetimeUsed;

    /**
     * `new CreditGetBalanceResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CreditGetBalanceResponse::with(
     *   autoTopupAmountDollars: ...,
     *   autoTopupEnabled: ...,
     *   autoTopupThreshold: ...,
     *   balance: ...,
     *   lifetimePurchased: ...,
     *   lifetimeUsed: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CreditGetBalanceResponse)
     *   ->withAutoTopupAmountDollars(...)
     *   ->withAutoTopupEnabled(...)
     *   ->withAutoTopupThreshold(...)
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
        float $autoTopupAmountDollars,
        bool $autoTopupEnabled,
        string $autoTopupThreshold,
        string $balance,
        string $lifetimePurchased,
        string $lifetimeUsed,
    ): self {
        $self = new self;

        $self['autoTopupAmountDollars'] = $autoTopupAmountDollars;
        $self['autoTopupEnabled'] = $autoTopupEnabled;
        $self['autoTopupThreshold'] = $autoTopupThreshold;
        $self['balance'] = $balance;
        $self['lifetimePurchased'] = $lifetimePurchased;
        $self['lifetimeUsed'] = $lifetimeUsed;

        return $self;
    }

    /**
     * Configured dollar amount for each automatic top-up.
     */
    public function withAutoTopupAmountDollars(
        float $autoTopupAmountDollars
    ): self {
        $self = clone $this;
        $self['autoTopupAmountDollars'] = $autoTopupAmountDollars;

        return $self;
    }

    public function withAutoTopupEnabled(bool $autoTopupEnabled): self
    {
        $self = clone $this;
        $self['autoTopupEnabled'] = $autoTopupEnabled;

        return $self;
    }

    /**
     * Credit balance threshold that triggers automatic top-up when enabled, represented as a bigint string.
     */
    public function withAutoTopupThreshold(string $autoTopupThreshold): self
    {
        $self = clone $this;
        $self['autoTopupThreshold'] = $autoTopupThreshold;

        return $self;
    }

    /**
     * Current credit balance as a bigint string to preserve precision above Number.MAX_SAFE_INTEGER.
     */
    public function withBalance(string $balance): self
    {
        $self = clone $this;
        $self['balance'] = $balance;

        return $self;
    }

    /**
     * Lifetime purchased credits as a bigint string.
     */
    public function withLifetimePurchased(string $lifetimePurchased): self
    {
        $self = clone $this;
        $self['lifetimePurchased'] = $lifetimePurchased;

        return $self;
    }

    /**
     * Lifetime consumed credits as a bigint string.
     */
    public function withLifetimeUsed(string $lifetimeUsed): self
    {
        $self = clone $this;
        $self['lifetimeUsed'] = $lifetimeUsed;

        return $self;
    }
}
