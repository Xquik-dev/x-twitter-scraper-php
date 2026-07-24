<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\GuestWallets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Confirmed USD amount for a guest wallet purchase.
 *
 * @phpstan-type GuestWalletAmountShape = array{amountMinor: int, currency: 'usd'}
 */
final class GuestWalletAmount implements BaseModel
{
    /** @use SdkModel<GuestWalletAmountShape> */
    use SdkModel;

    /** @var 'usd' $currency */
    #[Required]
    public string $currency = 'usd';

    /**
     * USD amount in cents. Accepted range is $10-$250.
     */
    #[Required('amount_minor')]
    public int $amountMinor;

    /**
     * `new GuestWalletAmount()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * GuestWalletAmount::with(amountMinor: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new GuestWalletAmount)->withAmountMinor(...)
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
    public static function with(int $amountMinor): self
    {
        $self = new self;

        $self['amountMinor'] = $amountMinor;

        return $self;
    }

    /**
     * USD amount in cents. Accepted range is $10-$250.
     */
    public function withAmountMinor(int $amountMinor): self
    {
        $self = clone $this;
        $self['amountMinor'] = $amountMinor;

        return $self;
    }

    /**
     * @param 'usd' $currency
     */
    public function withCurrency(string $currency): self
    {
        $self = clone $this;
        $self['currency'] = $currency;

        return $self;
    }
}
