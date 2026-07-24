<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\GuestWallets\GuestWalletGetStatusResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\GuestWallets\GuestWalletAmount;
use XTwitterScraper\GuestWallets\GuestWalletGetStatusResponse\LatestPurchase\Status;

/**
 * Latest guest wallet purchase fulfillment state.
 *
 * @phpstan-import-type GuestWalletAmountShape from \XTwitterScraper\GuestWallets\GuestWalletAmount
 *
 * @phpstan-type LatestPurchaseShape = array{
 *   amount: GuestWalletAmount|GuestWalletAmountShape,
 *   checkoutURL: string|null,
 *   credits: string,
 *   expiresAt: \DateTimeInterface,
 *   purchaseID: string,
 *   status: \XTwitterScraper\GuestWallets\GuestWalletGetStatusResponse\LatestPurchase\Status|value-of<\XTwitterScraper\GuestWallets\GuestWalletGetStatusResponse\LatestPurchase\Status>,
 * }
 */
final class LatestPurchase implements BaseModel
{
    /** @use SdkModel<LatestPurchaseShape> */
    use SdkModel;

    /**
     * Confirmed USD amount for a guest wallet purchase.
     */
    #[Required]
    public GuestWalletAmount $amount;

    /**
     * Present only while the purchase is pending.
     */
    #[Required('checkout_url')]
    public ?string $checkoutURL;

    #[Required]
    public string $credits;

    #[Required('expires_at')]
    public \DateTimeInterface $expiresAt;

    #[Required('purchase_id')]
    public string $purchaseID;

    /**
     * @var value-of<Status> $status
     */
    #[Required(
        enum: Status::class,
    )]
    public string $status;

    /**
     * `new LatestPurchase()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * LatestPurchase::with(
     *   amount: ...,
     *   checkoutURL: ...,
     *   credits: ...,
     *   expiresAt: ...,
     *   purchaseID: ...,
     *   status: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new LatestPurchase)
     *   ->withAmount(...)
     *   ->withCheckoutURL(...)
     *   ->withCredits(...)
     *   ->withExpiresAt(...)
     *   ->withPurchaseID(...)
     *   ->withStatus(...)
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
     * @param GuestWalletAmount|GuestWalletAmountShape $amount
     * @param Status|value-of<Status> $status
     */
    public static function with(
        GuestWalletAmount|array $amount,
        ?string $checkoutURL,
        string $credits,
        \DateTimeInterface $expiresAt,
        string $purchaseID,
        Status|string $status,
    ): self {
        $self = new self;

        $self['amount'] = $amount;
        $self['checkoutURL'] = $checkoutURL;
        $self['credits'] = $credits;
        $self['expiresAt'] = $expiresAt;
        $self['purchaseID'] = $purchaseID;
        $self['status'] = $status;

        return $self;
    }

    /**
     * Confirmed USD amount for a guest wallet purchase.
     *
     * @param GuestWalletAmount|GuestWalletAmountShape $amount
     */
    public function withAmount(GuestWalletAmount|array $amount): self
    {
        $self = clone $this;
        $self['amount'] = $amount;

        return $self;
    }

    /**
     * Present only while the purchase is pending.
     */
    public function withCheckoutURL(?string $checkoutURL): self
    {
        $self = clone $this;
        $self['checkoutURL'] = $checkoutURL;

        return $self;
    }

    public function withCredits(string $credits): self
    {
        $self = clone $this;
        $self['credits'] = $credits;

        return $self;
    }

    public function withExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }

    public function withPurchaseID(string $purchaseID): self
    {
        $self = clone $this;
        $self['purchaseID'] = $purchaseID;

        return $self;
    }

    /**
     * @param Status|value-of<Status> $status
     */
    public function withStatus(
        Status|string $status,
    ): self {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
