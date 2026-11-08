<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks\ReplyLock;

enum Reason: string
{
    case REPLIES_SHOW = 'replies_show';

    case REPLIES_MISSING = 'replies_missing';

    case NO_RECENT_REPLIES = 'no_recent_replies';

    case UNAVAILABLE = 'unavailable';

    case PROTECTED = 'protected';

    case SUSPENDED = 'suspended';
}
