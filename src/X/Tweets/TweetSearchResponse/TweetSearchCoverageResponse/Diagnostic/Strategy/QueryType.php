<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetSearchResponse\TweetSearchCoverageResponse\Diagnostic\Strategy;

enum QueryType: string
{
    case LATEST = 'Latest';

    case TOP = 'Top';
}
