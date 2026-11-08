<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Credits;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Currency;

/**
 * Create a hosted checkout only after the user confirms. The request never completes payment or adds credits.
 *
 * @see XTwitterScraper\Services\CreditsService::topupBalance()
 *
 * @phpstan-type CreditTopupBalanceParamsShape = array{
 *   dollars: int, locale?: string|null,
 *   currency?: Currency|value-of<Currency>|null,
 *   returnPath?: string|null,
 * }
 */
final class CreditTopupBalanceParams implements BaseModel
{
    /** @use SdkModel<CreditTopupBalanceParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Amount to top up in US dollars. Minimum 10.
     */
    #[Required]
    public int $dollars;

    /**
     * Optional checkout locale. Defaults to en.
     */
    #[Optional]
    public ?string $locale;

    /**
     * Currency to pay in. Xquik converts the dollar amount at the latest daily ECB rate. If the newest rates are more than 3 ECB working days old, it charges USD instead, and Checkout shows that before payment. `chargedCurrency` shows the currency charged. Credits always match the dollar amount. Lowercase codes work too.
     *
     * @var value-of<Currency>|null $currency
     */
    #[Optional(enum: Currency::class)]
    public ?string $currency;

    /**
     * Optional Xquik tool page to return to after Checkout, such as /en/x-article-reader.
     */
    #[Optional]
    public ?string $returnPath;

    /**
     * `new CreditTopupBalanceParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CreditTopupBalanceParams::with(dollars: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CreditTopupBalanceParams)->withDollars(...)
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
     * @param Currency|value-of<Currency>|null $currency
     */
    public static function with(int $dollars, ?string $locale = null, Currency|string|null $currency = null, ?string $returnPath = null): self
    {
        $self = new self;

        $self['dollars'] = $dollars;

        null !== $locale && $self['locale'] = $locale;

        null !== $currency && $self['currency'] = $currency;

        null !== $returnPath && $self['returnPath'] = $returnPath;

        return $self;
    }

    /**
     * Amount to top up in US dollars. Minimum 10.
     */
    public function withDollars(int $dollars): self
    {
        $self = clone $this;
        $self['dollars'] = $dollars;

        return $self;
    }

    /**
     * Optional checkout locale. Defaults to en.
     */
    public function withLocale(string $locale): self
    {
        $self = clone $this;
        $self['locale'] = $locale;

        return $self;
    }

    /**
     * Currency to pay in. Xquik converts the dollar amount at the latest daily ECB rate. If the newest rates are more than 3 ECB working days old, it charges USD instead, and Checkout shows that before payment. `chargedCurrency` shows the currency charged. Credits always match the dollar amount. Lowercase codes work too.
     *
     * @param Currency|value-of<Currency>|null $currency
     */
    public function withCurrency(Currency|string|null $currency): self
    {
        $self = clone $this;
        $self['currency'] = $currency;

        return $self;
    }

    /**
     * Optional Xquik tool page to return to after Checkout, such as /en/x-article-reader.
     */
    public function withReturnPath(?string $returnPath): self
    {
        $self = clone $this;
        $self['returnPath'] = $returnPath;

        return $self;
    }
}
