<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Currency;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\Subscribe\SubscribeCreateParams\Tier;
use XTwitterScraper\Subscribe\SubscribeNewResponse;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface SubscribeContract
{
    /**
     * @api
     *
     * @param Tier|value-of<Tier> $tier subscription tier to pre-select
     * @param Currency|value-of<Currency>|null $currency Currency to pay in. Lowercase codes work too. Xquik converts the USD plan price at the latest daily ECB rate. Each renewal charges the same amount before tax. An account that already pays in USD gets a USD checkout. With rates over 3 ECB working days old, the checkout charges USD. `chargedCurrency` shows the currency charged.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        Tier|string|null $tier = null,
        Currency|string|null $currency = null,
        RequestOptions|array|null $requestOptions = null
    ): SubscribeNewResponse;
}
