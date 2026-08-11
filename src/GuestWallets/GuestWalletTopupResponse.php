<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\GuestWallets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\GuestWallets\GuestWalletTopupResponse\Authorization;
use XTwitterScraper\GuestWallets\GuestWalletTopupResponse\CredentialNotice;
use XTwitterScraper\GuestWallets\GuestWalletTopupResponse\Status;

/**
 * Pending hosted checkout and guest wallet purchase details.
 *
 * @phpstan-import-type GuestWalletAmountShape from \XTwitterScraper\GuestWallets\GuestWalletAmount
 * @phpstan-import-type AuthorizationShape from \XTwitterScraper\GuestWallets\GuestWalletTopupResponse\Authorization
 *
 * @phpstan-type GuestWalletTopupResponseShape = array{
 *   accountRequired: bool,
 *   amount: GuestWalletAmount|GuestWalletAmountShape,
 *   checkoutURL: string,
 *   credits: string,
 *   expiresAt: \DateTimeInterface,
 *   instructions: string,
 *   pollAfterSeconds: 2,
 *   purchaseID: string,
 *   requiresUserInteraction: bool,
 *   status: Status|value-of<Status>,
 *   statusURL: 'https://xquik.com/api/v1/guest-wallets/status',
 *   walletID: string,
 *   apiKey?: string|null,
 *   authorization?: null|Authorization|AuthorizationShape,
 *   credentialNotice?: null|CredentialNotice|value-of<CredentialNotice>,
 * }
 */
final class GuestWalletTopupResponse implements BaseModel
{
    /** @use SdkModel<GuestWalletTopupResponseShape> */
    use SdkModel;

    #[Required('account_required')]
    public bool $accountRequired = false;

    /**
     * Wait at least this long before polling status_url.
     *
     * @var 2 $pollAfterSeconds
     */
    #[Required('poll_after_seconds')]
    public int $pollAfterSeconds = 2;

    #[Required('requires_user_interaction')]
    public bool $requiresUserInteraction = true;

    /** @var 'https://xquik.com/api/v1/guest-wallets/status' $statusURL */
    #[Required('status_url')]
    public string $statusURL = 'https://xquik.com/api/v1/guest-wallets/status';

    /**
     * Confirmed USD amount for a guest wallet purchase.
     */
    #[Required]
    public GuestWalletAmount $amount;

    /**
     * Hosted checkout URL for user interaction.
     */
    #[Required('checkout_url')]
    public string $checkoutURL;

    /**
     * Credits granted after verified payment.
     */
    #[Required]
    public string $credits;

    /**
     * Time when the pending checkout expires.
     */
    #[Required('expires_at')]
    public \DateTimeInterface $expiresAt;

    /**
     * Hosted checkout and status polling instructions.
     */
    #[Required]
    public string $instructions;

    #[Required('purchase_id')]
    public string $purchaseID;

    /** @var value-of<Status> $status */
    #[Required(enum: Status::class)]
    public string $status;

    #[Required('wallet_id')]
    public string $walletID;

    /**
     * Paid-read bearer credential returned only by initial creation. Store it as a secret. Never place it in a URL or log.
     */
    #[Optional('api_key')]
    public ?string $apiKey;

    #[Optional]
    public ?Authorization $authorization;

    /** @var value-of<CredentialNotice>|null $credentialNotice */
    #[Optional('credential_notice', enum: CredentialNotice::class)]
    public ?string $credentialNotice;

    /**
     * `new GuestWalletTopupResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * GuestWalletTopupResponse::with(
     *   amount: ...,
     *   checkoutURL: ...,
     *   credits: ...,
     *   expiresAt: ...,
     *   instructions: ...,
     *   purchaseID: ...,
     *   status: ...,
     *   walletID: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new GuestWalletTopupResponse)
     *   ->withAmount(...)
     *   ->withCheckoutURL(...)
     *   ->withCredits(...)
     *   ->withExpiresAt(...)
     *   ->withInstructions(...)
     *   ->withPurchaseID(...)
     *   ->withStatus(...)
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
     * @param GuestWalletAmount|GuestWalletAmountShape $amount
     * @param Status|value-of<Status> $status
     * @param Authorization|AuthorizationShape|null $authorization
     * @param CredentialNotice|value-of<CredentialNotice>|null $credentialNotice
     */
    public static function with(
        GuestWalletAmount|array $amount,
        string $checkoutURL,
        string $credits,
        \DateTimeInterface $expiresAt,
        string $instructions,
        string $purchaseID,
        Status|string $status,
        string $walletID,
        ?string $apiKey = null,
        Authorization|array|null $authorization = null,
        CredentialNotice|string|null $credentialNotice = null,
    ): self {
        $self = new self;

        $self['amount'] = $amount;
        $self['checkoutURL'] = $checkoutURL;
        $self['credits'] = $credits;
        $self['expiresAt'] = $expiresAt;
        $self['instructions'] = $instructions;
        $self['purchaseID'] = $purchaseID;
        $self['status'] = $status;
        $self['walletID'] = $walletID;

        null !== $apiKey && $self['apiKey'] = $apiKey;
        null !== $authorization && $self['authorization'] = $authorization;
        null !== $credentialNotice && $self['credentialNotice'] = $credentialNotice;

        return $self;
    }

    public function withAccountRequired(bool $accountRequired): self
    {
        $self = clone $this;
        $self['accountRequired'] = $accountRequired;

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
     * Hosted checkout URL for user interaction.
     */
    public function withCheckoutURL(string $checkoutURL): self
    {
        $self = clone $this;
        $self['checkoutURL'] = $checkoutURL;

        return $self;
    }

    /**
     * Credits granted after verified payment.
     */
    public function withCredits(string $credits): self
    {
        $self = clone $this;
        $self['credits'] = $credits;

        return $self;
    }

    /**
     * Time when the pending checkout expires.
     */
    public function withExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }

    /**
     * Hosted checkout and status polling instructions.
     */
    public function withInstructions(string $instructions): self
    {
        $self = clone $this;
        $self['instructions'] = $instructions;

        return $self;
    }

    /**
     * Wait at least this long before polling status_url.
     *
     * @param 2 $pollAfterSeconds
     */
    public function withPollAfterSeconds(int $pollAfterSeconds): self
    {
        $self = clone $this;
        $self['pollAfterSeconds'] = $pollAfterSeconds;

        return $self;
    }

    public function withPurchaseID(string $purchaseID): self
    {
        $self = clone $this;
        $self['purchaseID'] = $purchaseID;

        return $self;
    }

    public function withRequiresUserInteraction(
        bool $requiresUserInteraction
    ): self {
        $self = clone $this;
        $self['requiresUserInteraction'] = $requiresUserInteraction;

        return $self;
    }

    /**
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * @param 'https://xquik.com/api/v1/guest-wallets/status' $statusURL
     */
    public function withStatusURL(string $statusURL): self
    {
        $self = clone $this;
        $self['statusURL'] = $statusURL;

        return $self;
    }

    public function withWalletID(string $walletID): self
    {
        $self = clone $this;
        $self['walletID'] = $walletID;

        return $self;
    }

    /**
     * Paid-read bearer credential returned only by initial creation. Store it as a secret. Never place it in a URL or log.
     */
    public function withAPIKey(string $apiKey): self
    {
        $self = clone $this;
        $self['apiKey'] = $apiKey;

        return $self;
    }

    /**
     * @param Authorization|AuthorizationShape $authorization
     */
    public function withAuthorization(Authorization|array $authorization): self
    {
        $self = clone $this;
        $self['authorization'] = $authorization;

        return $self;
    }

    /**
     * @param CredentialNotice|value-of<CredentialNotice> $credentialNotice
     */
    public function withCredentialNotice(
        CredentialNotice|string $credentialNotice
    ): self {
        $self = clone $this;
        $self['credentialNotice'] = $credentialNotice;

        return $self;
    }
}
