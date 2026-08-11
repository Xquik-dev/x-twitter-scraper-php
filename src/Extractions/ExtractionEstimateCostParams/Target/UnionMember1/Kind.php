<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionEstimateCostParams\Target\UnionMember1;

enum Kind: string
{
    case FAVORITERS = 'favoriters';

    case LIST = 'list';

    case PROFILE = 'profile';

    case PROFILE_LIKES = 'profile_likes';

    case PROFILE_MEDIA = 'profile_media';

    case PROFILE_REPLIES = 'profile_replies';

    case QUOTES = 'quotes';

    case REPLIES = 'replies';

    case RETWEETERS = 'retweeters';

    case SEARCH = 'search';

    case THREAD = 'thread';

    case TWEET = 'tweet';
}
