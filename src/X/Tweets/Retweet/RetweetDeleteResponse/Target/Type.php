<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\Retweet\RetweetDeleteResponse\Target;

enum Type: string
{
    case TWEET = 'tweet';

    case USER = 'user';

    case COMMUNITY = 'community';
}
