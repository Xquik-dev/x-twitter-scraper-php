<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetGetRepliesParams;

/**
 * Select all replies, direct replies, or nested replies.
 */
enum Scope: string
{
    case ALL = 'all';

    case DIRECT = 'direct';

    case NESTED = 'nested';
}
