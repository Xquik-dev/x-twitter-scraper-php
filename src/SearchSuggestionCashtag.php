<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type SearchSuggestionCashtagShape = array{
 *   ticker: string,
 *   name?: string|null,
 *   smartTag?: string|null,
 *   currency?: string|null,
 *   price?: string|null,
 *   marketCap?: string|null,
 *   dailyChangePercent?: float|null,
 *   logoUrl?: string|null,
 *   exchangeShortName?: string|null,
 *   contractAddress?: string|null,
 *   chainLogoUrl?: string|null,
 * }
 */
final class SearchSuggestionCashtag implements BaseModel
{
    /** @use SdkModel<SearchSuggestionCashtagShape> */
    use SdkModel;

    /**
     * Ticker symbol without the $.
     */
    #[Required]
    public string $ticker;

    /**
     * Company or token name.
     */
    #[Optional]
    public ?string $name;

    /**
     * X's tag for the asset. $TICKER for a stock, chain:contract for a token.
     */
    #[Optional]
    public ?string $smartTag;

    /**
     * Currency of price & marketCap.
     */
    #[Optional]
    public ?string $currency;

    /**
     * Latest price as decimal text, which keeps every digit.
     */
    #[Optional]
    public ?string $price;

    /**
     * Market capitalization as decimal text.
     */
    #[Optional]
    public ?string $marketCap;

    /**
     * Price change over the last 24 hours, in percent.
     */
    #[Optional]
    public ?float $dailyChangePercent;

    /**
     * Logo image URL.
     */
    #[Optional]
    public ?string $logoUrl;

    /**
     * Stock exchange. Stocks only.
     */
    #[Optional]
    public ?string $exchangeShortName;

    /**
     * Token contract address. Tokens only.
     */
    #[Optional]
    public ?string $contractAddress;

    /**
     * Logo of the token's chain. Tokens only.
     */
    #[Optional]
    public ?string $chainLogoUrl;

    /**
     * `new SearchSuggestionCashtag()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SearchSuggestionCashtag::with(ticker: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SearchSuggestionCashtag)->withTicker(...)
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
    public static function with(string $ticker, ?string $name = null, ?string $smartTag = null, ?string $currency = null, ?string $price = null, ?string $marketCap = null, ?float $dailyChangePercent = null, ?string $logoUrl = null, ?string $exchangeShortName = null, ?string $contractAddress = null, ?string $chainLogoUrl = null): self
    {
        $self = new self;

        $self['ticker'] = $ticker;

        null !== $name && $self['name'] = $name;
        null !== $smartTag && $self['smartTag'] = $smartTag;
        null !== $currency && $self['currency'] = $currency;
        null !== $price && $self['price'] = $price;
        null !== $marketCap && $self['marketCap'] = $marketCap;
        null !== $dailyChangePercent && $self['dailyChangePercent'] = $dailyChangePercent;
        null !== $logoUrl && $self['logoUrl'] = $logoUrl;
        null !== $exchangeShortName && $self['exchangeShortName'] = $exchangeShortName;
        null !== $contractAddress && $self['contractAddress'] = $contractAddress;
        null !== $chainLogoUrl && $self['chainLogoUrl'] = $chainLogoUrl;

        return $self;
    }

    /**
     * Ticker symbol without the $.
     */
    public function withTicker(string $ticker): self
    {
        $self = clone $this;
        $self['ticker'] = $ticker;

        return $self;
    }

    /**
     * Company or token name.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * X's tag for the asset. $TICKER for a stock, chain:contract for a token.
     */
    public function withSmartTag(?string $smartTag): self
    {
        $self = clone $this;
        $self['smartTag'] = $smartTag;

        return $self;
    }

    /**
     * Currency of price & marketCap.
     */
    public function withCurrency(?string $currency): self
    {
        $self = clone $this;
        $self['currency'] = $currency;

        return $self;
    }

    /**
     * Latest price as decimal text, which keeps every digit.
     */
    public function withPrice(?string $price): self
    {
        $self = clone $this;
        $self['price'] = $price;

        return $self;
    }

    /**
     * Market capitalization as decimal text.
     */
    public function withMarketCap(?string $marketCap): self
    {
        $self = clone $this;
        $self['marketCap'] = $marketCap;

        return $self;
    }

    /**
     * Price change over the last 24 hours, in percent.
     */
    public function withDailyChangePercent(?float $dailyChangePercent): self
    {
        $self = clone $this;
        $self['dailyChangePercent'] = $dailyChangePercent;

        return $self;
    }

    /**
     * Logo image URL.
     */
    public function withLogoUrl(?string $logoUrl): self
    {
        $self = clone $this;
        $self['logoUrl'] = $logoUrl;

        return $self;
    }

    /**
     * Stock exchange. Stocks only.
     */
    public function withExchangeShortName(?string $exchangeShortName): self
    {
        $self = clone $this;
        $self['exchangeShortName'] = $exchangeShortName;

        return $self;
    }

    /**
     * Token contract address. Tokens only.
     */
    public function withContractAddress(?string $contractAddress): self
    {
        $self = clone $this;
        $self['contractAddress'] = $contractAddress;

        return $self;
    }

    /**
     * Logo of the token's chain. Tokens only.
     */
    public function withChainLogoUrl(?string $chainLogoUrl): self
    {
        $self = clone $this;
        $self['chainLogoUrl'] = $chainLogoUrl;

        return $self;
    }
}
