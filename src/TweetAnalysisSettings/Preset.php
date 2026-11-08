<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetAnalysisSettings;

enum Preset: string
{
    case BRAND = 'brand';

    case COMPLAINTS = 'complaints';

    case COMPETITORS = 'competitors';

    case PURCHASE_INTENT = 'purchase_intent';

    case PRODUCT_FEEDBACK = 'product_feedback';

    case NEWS = 'news';

    case SENTIMENT = 'sentiment';

    case MARKET = 'market';

    case VIRAL_LITE = 'viral_lite';
}
