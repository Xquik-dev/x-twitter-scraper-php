<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\GuestWallets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Create a one-use hosted checkout after the user confirms $10-$250 USD. The request creates no charge. It returns a paid-read API key without an Xquik account. Idempotent replays return the same key.
 *
 * @see XTwitterScraper\Services\GuestWalletsService::create()
 *
 * @phpstan-type GuestWalletCreateParamsShape = array{
 *   currency: 'usd', amountMinor: int, idempotencyKey: string
 * }
 */
final class GuestWalletCreateParams implements BaseModel
{
    /** @use SdkModel<GuestWalletCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /** @var 'usd' $currency */
    #[Required]
    public string $currency = 'usd';

    /**
     * USD cents accepted for this checkout.
     */
    #[Required('amount_minor')]
    public int $amountMinor;

    #[Required]
    public string $idempotencyKey;

    /**
     * `new GuestWalletCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * GuestWalletCreateParams::with(amountMinor: ..., idempotencyKey: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new GuestWalletCreateParams)->withAmountMinor(...)->withIdempotencyKey(...)
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
    public static function with(int $amountMinor, string $idempotencyKey): self
    {
        $self = new self;

        $self['amountMinor'] = $amountMinor;
        $self['idempotencyKey'] = $idempotencyKey;

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

    /**
     * USD cents accepted for this checkout.
     */
    public function withAmountMinor(int $amountMinor): self
    {
        $self = clone $this;
        $self['amountMinor'] = $amountMinor;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }
}
