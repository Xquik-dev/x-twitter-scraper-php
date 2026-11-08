<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\SearchTweet;

enum UnknownCounts: string
{
    case RETWEET_COUNT = 'retweetCount';

    case REPLY_COUNT = 'replyCount';

    case LIKE_COUNT = 'likeCount';

    case QUOTE_COUNT = 'quoteCount';

    case VIEW_COUNT = 'viewCount';

    case BOOKMARK_COUNT = 'bookmarkCount';
}
