<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\Like\LikeDeleteResponse\Result;

enum Type: string
{
    case TWEET = 'tweet';

    case DIRECT_MESSAGE = 'direct_message';

    case MEDIA = 'media';

    case COMMUNITY = 'community';

    case STATE_CHANGE = 'state_change';
}
