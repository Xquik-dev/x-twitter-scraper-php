<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetListTopParams;

enum Window: string
{
    case DAY = 'day';

    case WEEK = 'week';

    case MONTH = 'month';
}
