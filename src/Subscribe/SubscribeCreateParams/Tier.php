<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Subscribe\SubscribeCreateParams;

/**
 * Subscription tier to pre-select.
 */
enum Tier: string
{
    case STARTER = 'starter';

    case PRO = 'pro';

    case BUSINESS = 'business';
}
