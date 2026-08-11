<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetGetRepliesParams;

/**
 * Sort the selected replies before applying limit.
 */
enum Sort: string
{
    case RELEVANCE = 'relevance';

    case LATEST = 'latest';

    case OLDEST = 'oldest';

    case LIKES = 'likes';
}
