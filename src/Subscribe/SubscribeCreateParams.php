<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Subscribe;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Currency;
use XTwitterScraper\Subscribe\SubscribeCreateParams\Tier;

/**
 * Create a subscription checkout or billing-management URL only after the user confirms. The request never completes payment by itself.
 *
 * @see XTwitterScraper\Services\SubscribeService::create()
 *
 * @phpstan-type SubscribeCreateParamsShape = array{
 *   tier?: null|Tier|value-of<Tier>,
 *   currency?: Currency|value-of<Currency>|null,
 * }
 */
final class SubscribeCreateParams implements BaseModel
{
    /** @use SdkModel<SubscribeCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Subscription tier to pre-select.
     *
     * @var value-of<Tier>|null $tier
     */
    #[Optional(enum: Tier::class)]
    public ?string $tier;

    /**
     * Currency to pay in. Lowercase codes work too. Xquik converts the USD plan price at the latest daily ECB rate. Each renewal charges the same amount before tax. An account that already pays in USD gets a USD checkout. With rates over 3 ECB working days old, the checkout charges USD. `chargedCurrency` shows the currency charged.
     *
     * @var value-of<Currency>|null $currency
     */
    #[Optional(enum: Currency::class)]
    public ?string $currency;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Tier|value-of<Tier>|null $tier
     * @param Currency|value-of<Currency>|null $currency
     */
    public static function with(Tier|string|null $tier = null, Currency|string|null $currency = null): self
    {
        $self = new self;

        null !== $tier && $self['tier'] = $tier;

        null !== $currency && $self['currency'] = $currency;

        return $self;
    }

    /**
     * Subscription tier to pre-select.
     *
     * @param Tier|value-of<Tier> $tier
     */
    public function withTier(Tier|string $tier): self
    {
        $self = clone $this;
        $self['tier'] = $tier;

        return $self;
    }

    /**
     * Currency to pay in. Lowercase codes work too. Xquik converts the USD plan price at the latest daily ECB rate. Each renewal charges the same amount before tax. An account that already pays in USD gets a USD checkout. With rates over 3 ECB working days old, the checkout charges USD. `chargedCurrency` shows the currency charged.
     *
     * @param Currency|value-of<Currency>|null $currency
     */
    public function withCurrency(Currency|string|null $currency): self
    {
        $self = clone $this;
        $self['currency'] = $currency;

        return $self;
    }
}
