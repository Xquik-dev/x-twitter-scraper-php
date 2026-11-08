<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetListTopParams;

enum Metric: string
{
    case LIKES = 'likes';

    case REPLIES = 'replies';

    case QUOTES = 'quotes';

    case BOOKMARKS = 'bookmarks';

    case SHARES = 'shares';

    case VIEWS = 'views';
}
