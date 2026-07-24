<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Account\AccountGetResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CreditInfoShape = array{
 *   autoTopupAmountDollars: float,
 *   autoTopupEnabled: bool,
 *   autoTopupThreshold: string,
 *   balance: string,
 *   lifetimePurchased: string,
 *   lifetimeUsed: string,
 * }
 */
final class CreditInfo implements BaseModel
{
    /** @use SdkModel<CreditInfoShape> */
    use SdkModel;

    /**
     * Dollar amount charged when automatic top-up runs.
     */
    #[Required]
    public float $autoTopupAmountDollars;

    #[Required]
    public bool $autoTopupEnabled;

    /**
     * Bigint string threshold that triggers automatic top-up when enabled.
     */
    #[Required]
    public string $autoTopupThreshold;

    /**
     * Bigint string to preserve precision above Number.MAX_SAFE_INTEGER.
     */
    #[Required]
    public string $balance;

    /**
     * Total purchased credits as a bigint string.
     */
    #[Required]
    public string $lifetimePurchased;

    /**
     * Total consumed credits as a bigint string.
     */
    #[Required]
    public string $lifetimeUsed;

    /**
     * `new CreditInfo()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CreditInfo::with(
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
     * (new CreditInfo)
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
     * Dollar amount charged when automatic top-up runs.
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
     * Bigint string threshold that triggers automatic top-up when enabled.
     */
    public function withAutoTopupThreshold(string $autoTopupThreshold): self
    {
        $self = clone $this;
        $self['autoTopupThreshold'] = $autoTopupThreshold;

        return $self;
    }

    /**
     * Bigint string to preserve precision above Number.MAX_SAFE_INTEGER.
     */
    public function withBalance(string $balance): self
    {
        $self = clone $this;
        $self['balance'] = $balance;

        return $self;
    }

    /**
     * Total purchased credits as a bigint string.
     */
    public function withLifetimePurchased(string $lifetimePurchased): self
    {
        $self = clone $this;
        $self['lifetimePurchased'] = $lifetimePurchased;

        return $self;
    }

    /**
     * Total consumed credits as a bigint string.
     */
    public function withLifetimeUsed(string $lifetimeUsed): self
    {
        $self = clone $this;
        $self['lifetimeUsed'] = $lifetimeUsed;

        return $self;
    }
}
