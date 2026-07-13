<?php

declare(strict_types=1);

namespace XTwitterScraper\GuestWallets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Create a one-use Stripe-hosted checkout for an existing paid-read guest key after the user explicitly confirms a $10-$250 USD amount. The key remains the same. This request creates no charge by itself and never redirects through an Xquik web page.
 *
 * @see XTwitterScraper\Services\GuestWalletsService::topup()
 *
 * @phpstan-type GuestWalletTopupParamsShape = array{
 *   currency: 'usd', amountMinor: int, idempotencyKey: string
 * }
 */
final class GuestWalletTopupParams implements BaseModel
{
    /** @use SdkModel<GuestWalletTopupParamsShape> */
    use SdkModel;
    use SdkParams;

    /** @var 'usd' $currency */
    #[Required]
    public string $currency = 'usd';

    /**
     * Confirmed USD amount in cents.
     */
    #[Required('amount_minor')]
    public int $amountMinor;

    #[Required]
    public string $idempotencyKey;

    /**
     * `new GuestWalletTopupParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * GuestWalletTopupParams::with(amountMinor: ..., idempotencyKey: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new GuestWalletTopupParams)->withAmountMinor(...)->withIdempotencyKey(...)
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
     * Confirmed USD amount in cents.
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
