<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Credits;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Credits\CreditGetTopupStatusResponse\Status;
use XTwitterScraper\Currency;

/**
 * @phpstan-type CreditGetTopupStatusResponseShape = array{
 *   status: Status|value-of<Status>,
 *   amountDollars?: int|null,
 *   credits?: string|null,
 *   chargedCurrency?: Currency|value-of<Currency>|null,
 *   chargedMinorUnits?: int|null,
 * }
 */
final class CreditGetTopupStatusResponse implements BaseModel
{
    /** @use SdkModel<CreditGetTopupStatusResponseShape> */
    use SdkModel;

    /** @var value-of<Status> $status */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * Dollar amount requested for the top-up.
     */
    #[Optional('amount_dollars', nullable: true)]
    public ?int $amountDollars;

    /**
     * Bigint string credit amount granted or pending.
     */
    #[Optional]
    public ?string $credits;

    /**
     * Currency the checkout charged.
     *
     * @var value-of<Currency>|null $chargedCurrency
     */
    #[Optional(enum: Currency::class)]
    public ?string $chargedCurrency;

    /**
     * Amount the checkout charged before tax, in the currency's smallest unit. JPY and KRW have no decimals, so 1580 JPY is ¥1,580.
     */
    #[Optional]
    public ?int $chargedMinorUnits;

    /**
     * `new CreditGetTopupStatusResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CreditGetTopupStatusResponse::with(status: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CreditGetTopupStatusResponse)->withStatus(...)
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
     * @param Status|value-of<Status> $status
     * @param Currency|value-of<Currency>|null $chargedCurrency
     */
    public static function with(
        Status|string $status,
        ?int $amountDollars = null,
        ?string $credits = null,
        Currency|string|null $chargedCurrency = null,
        ?int $chargedMinorUnits = null
    ): self {
        $self = new self;

        $self['status'] = $status;

        null !== $amountDollars && $self['amountDollars'] = $amountDollars;
        null !== $credits && $self['credits'] = $credits;

        null !== $chargedCurrency && $self['chargedCurrency'] = $chargedCurrency;

        null !== $chargedMinorUnits && $self['chargedMinorUnits'] = $chargedMinorUnits;

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
     * Dollar amount requested for the top-up.
     */
    public function withAmountDollars(?int $amountDollars): self
    {
        $self = clone $this;
        $self['amountDollars'] = $amountDollars;

        return $self;
    }

    /**
     * Bigint string credit amount granted or pending.
     */
    public function withCredits(string $credits): self
    {
        $self = clone $this;
        $self['credits'] = $credits;

        return $self;
    }

    /**
     * Currency the checkout charged.
     *
     * @param Currency|value-of<Currency>|null $chargedCurrency
     */
    public function withChargedCurrency(Currency|string|null $chargedCurrency): self
    {
        $self = clone $this;
        $self['chargedCurrency'] = $chargedCurrency;

        return $self;
    }

    /**
     * Amount the checkout charged before tax, in the currency's smallest unit. JPY and KRW have no decimals, so 1580 JPY is ¥1,580.
     */
    public function withChargedMinorUnits(?int $chargedMinorUnits): self
    {
        $self = clone $this;
        $self['chargedMinorUnits'] = $chargedMinorUnits;

        return $self;
    }
}
