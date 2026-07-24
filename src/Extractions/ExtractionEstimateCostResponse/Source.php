<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionEstimateCostResponse;

enum Source: string
{
    case FOLLOWERS = 'followers';

    case FOLLOWING = 'following';

    case PAGINATION_CAP = 'paginationCap';

    case POSTS = 'posts';

    case QUOTE_COUNT = 'quoteCount';

    case REPLY_COUNT = 'replyCount';

    case RESULTS_LIMIT = 'resultsLimit';

    case RETWEET_COUNT = 'retweetCount';

    case UNKNOWN = 'unknown';
}
