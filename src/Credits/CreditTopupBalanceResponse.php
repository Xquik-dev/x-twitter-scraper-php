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
use XTwitterScraper\Currency;

/**
 * @phpstan-type CreditTopupBalanceResponseShape = array{
 *   redirectURL: string, url: string,
 *   chargedCurrency?: Currency|value-of<Currency>|null,
 *   chargedMinorUnits?: int|null,
 * }
 */
final class CreditTopupBalanceResponse implements BaseModel
{
    /** @use SdkModel<CreditTopupBalanceResponseShape> */
    use SdkModel;

    /**
     * Stable Xquik redirect URL for the active checkout.
     */
    #[Required('redirect_url')]
    public string $redirectURL;

    /**
     * Same stable Xquik redirect URL as redirect_url. The response never exposes the hosted checkout URL.
     */
    #[Required]
    public string $url;

    /**
     * Currency the checkout charges.
     *
     * @var value-of<Currency>|null $chargedCurrency
     */
    #[Optional(enum: Currency::class)]
    public ?string $chargedCurrency;

    /**
     * Amount the checkout charges before tax, in the currency's smallest unit. JPY and KRW have no decimals, so 1580 JPY is ¥1,580.
     */
    #[Optional]
    public ?int $chargedMinorUnits;

    /**
     * `new CreditTopupBalanceResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CreditTopupBalanceResponse::with(redirectURL: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CreditTopupBalanceResponse)->withRedirectURL(...)->withURL(...)
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
     * @param Currency|value-of<Currency>|null $chargedCurrency
     */
    public static function with(string $redirectURL, string $url, Currency|string|null $chargedCurrency = null, ?int $chargedMinorUnits = null): self
    {
        $self = new self;

        $self['redirectURL'] = $redirectURL;
        $self['url'] = $url;

        null !== $chargedCurrency && $self['chargedCurrency'] = $chargedCurrency;

        null !== $chargedMinorUnits && $self['chargedMinorUnits'] = $chargedMinorUnits;

        return $self;
    }

    /**
     * Stable Xquik redirect URL for the active checkout.
     */
    public function withRedirectURL(string $redirectURL): self
    {
        $self = clone $this;
        $self['redirectURL'] = $redirectURL;

        return $self;
    }

    /**
     * Same stable Xquik redirect URL as redirect_url. The response never exposes the hosted checkout URL.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Currency the checkout charges.
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
     * Amount the checkout charges before tax, in the currency's smallest unit. JPY and KRW have no decimals, so 1580 JPY is ¥1,580.
     */
    public function withChargedMinorUnits(?int $chargedMinorUnits): self
    {
        $self = clone $this;
        $self['chargedMinorUnits'] = $chargedMinorUnits;

        return $self;
    }
}
