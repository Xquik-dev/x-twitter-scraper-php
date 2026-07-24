<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\GuestWallets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\GuestWallets\GuestWalletGetStatusResponse\LatestPurchase;
use XTwitterScraper\GuestWallets\GuestWalletGetStatusResponse\PollAfterSeconds;
use XTwitterScraper\GuestWallets\GuestWalletGetStatusResponse\Status;
use XTwitterScraper\GuestWallets\GuestWalletGetStatusResponse\TopUp;

/**
 * Current balance, usability, and latest guest purchase state.
 *
 * @phpstan-import-type LatestPurchaseShape from \XTwitterScraper\GuestWallets\GuestWalletGetStatusResponse\LatestPurchase
 * @phpstan-import-type TopUpShape from \XTwitterScraper\GuestWallets\GuestWalletGetStatusResponse\TopUp
 *
 * @phpstan-type GuestWalletGetStatusResponseShape = array{
 *   balance: string,
 *   latestPurchase: null|LatestPurchase|LatestPurchaseShape,
 *   pollAfterSeconds: null|PollAfterSeconds|value-of<PollAfterSeconds>,
 *   scope: 'paid_reads',
 *   status: Status|value-of<Status>,
 *   topUp: null|TopUp|TopUpShape,
 *   usable: bool,
 *   walletID: string,
 * }
 */
final class GuestWalletGetStatusResponse implements BaseModel
{
    /** @use SdkModel<GuestWalletGetStatusResponseShape> */
    use SdkModel;

    /** @var 'paid_reads' $scope */
    #[Required]
    public string $scope = 'paid_reads';

    #[Required]
    public string $balance;

    /**
     * Latest guest wallet purchase fulfillment state.
     */
    #[Required('latest_purchase')]
    public ?LatestPurchase $latestPurchase;

    /**
     * Polling delay while payment is pending. Null means stop.
     *
     * @var value-of<PollAfterSeconds>|null $pollAfterSeconds
     */
    #[Required('poll_after_seconds', enum: PollAfterSeconds::class)]
    public ?int $pollAfterSeconds;

    /**
     * Combined wallet and pending-checkout state. A pending top-up can coexist with usable true. Terminal expired or failed states require a new guest wallet.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * Top-up action when usable and no checkout is pending.
     */
    #[Required('top_up')]
    public ?TopUp $topUp;

    /**
     * Authoritative paid-read readiness. Use instead of status.
     */
    #[Required]
    public bool $usable;

    #[Required('wallet_id')]
    public string $walletID;

    /**
     * `new GuestWalletGetStatusResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * GuestWalletGetStatusResponse::with(
     *   balance: ...,
     *   latestPurchase: ...,
     *   pollAfterSeconds: ...,
     *   status: ...,
     *   topUp: ...,
     *   usable: ...,
     *   walletID: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new GuestWalletGetStatusResponse)
     *   ->withBalance(...)
     *   ->withLatestPurchase(...)
     *   ->withPollAfterSeconds(...)
     *   ->withStatus(...)
     *   ->withTopUp(...)
     *   ->withUsable(...)
     *   ->withWalletID(...)
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
     * @param LatestPurchase|LatestPurchaseShape|null $latestPurchase
     * @param PollAfterSeconds|value-of<PollAfterSeconds>|null $pollAfterSeconds
     * @param Status|value-of<Status> $status
     * @param TopUp|TopUpShape|null $topUp
     */
    public static function with(
        string $balance,
        LatestPurchase|array|null $latestPurchase,
        PollAfterSeconds|int|null $pollAfterSeconds,
        Status|string $status,
        TopUp|array|null $topUp,
        bool $usable,
        string $walletID,
    ): self {
        $self = new self;

        $self['balance'] = $balance;
        $self['latestPurchase'] = $latestPurchase;
        $self['pollAfterSeconds'] = $pollAfterSeconds;
        $self['status'] = $status;
        $self['topUp'] = $topUp;
        $self['usable'] = $usable;
        $self['walletID'] = $walletID;

        return $self;
    }

    public function withBalance(string $balance): self
    {
        $self = clone $this;
        $self['balance'] = $balance;

        return $self;
    }

    /**
     * Latest guest wallet purchase fulfillment state.
     *
     * @param LatestPurchase|LatestPurchaseShape|null $latestPurchase
     */
    public function withLatestPurchase(
        LatestPurchase|array|null $latestPurchase
    ): self {
        $self = clone $this;
        $self['latestPurchase'] = $latestPurchase;

        return $self;
    }

    /**
     * Polling delay while payment is pending. Null means stop.
     *
     * @param PollAfterSeconds|value-of<PollAfterSeconds>|null $pollAfterSeconds
     */
    public function withPollAfterSeconds(
        PollAfterSeconds|int|null $pollAfterSeconds
    ): self {
        $self = clone $this;
        $self['pollAfterSeconds'] = $pollAfterSeconds;

        return $self;
    }

    /**
     * @param 'paid_reads' $scope
     */
    public function withScope(string $scope): self
    {
        $self = clone $this;
        $self['scope'] = $scope;

        return $self;
    }

    /**
     * Combined wallet and pending-checkout state. A pending top-up can coexist with usable true. Terminal expired or failed states require a new guest wallet.
     *
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * Top-up action when usable and no checkout is pending.
     *
     * @param TopUp|TopUpShape|null $topUp
     */
    public function withTopUp(TopUp|array|null $topUp): self
    {
        $self = clone $this;
        $self['topUp'] = $topUp;

        return $self;
    }

    /**
     * Authoritative paid-read readiness. Use instead of status.
     */
    public function withUsable(bool $usable): self
    {
        $self = clone $this;
        $self['usable'] = $usable;

        return $self;
    }

    public function withWalletID(string $walletID): self
    {
        $self = clone $this;
        $self['walletID'] = $walletID;

        return $self;
    }
}
