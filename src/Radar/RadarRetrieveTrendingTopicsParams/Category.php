<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Radar\RadarRetrieveTrendingTopicsParams;

/**
 * Filter by category.
 */
enum Category: string
{
    case GENERAL = 'general';

    case TECH = 'tech';

    case DEV = 'dev';

    case SCIENCE = 'science';

    case CULTURE = 'culture';

    case POLITICS = 'politics';

    case BUSINESS = 'business';

    case ENTERTAINMENT = 'entertainment';
}
