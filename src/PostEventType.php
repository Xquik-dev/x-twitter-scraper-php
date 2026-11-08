<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

enum PostEventType: string
{
    case POST_REPLY_NEW = 'post.reply.new';

    case POST_QUOTE_NEW = 'post.quote.new';

    case POST_LIKES_CHANGED = 'post.likes.changed';

    case POST_RETWEETS_CHANGED = 'post.retweets.changed';

    case POST_REPLIES_CHANGED = 'post.replies.changed';

    case POST_QUOTES_CHANGED = 'post.quotes.changed';

    case POST_BOOKMARKS_CHANGED = 'post.bookmarks.changed';

    case POST_VIEWS_CHANGED = 'post.views.changed';

    case POST_EDITED = 'post.edited';

    case POST_DELETED = 'post.deleted';
}
