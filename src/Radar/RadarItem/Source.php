<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Radar\RadarItem;

enum Source: string
{
    case GITHUB = 'github';

    case GOOGLE_TRENDS = 'google_trends';

    case HACKER_NEWS = 'hacker_news';

    case POLYMARKET = 'polymarket';

    case REDDIT = 'reddit';

    case TRUSTMRR = 'trustmrr';

    case WIKIPEDIA = 'wikipedia';
}
