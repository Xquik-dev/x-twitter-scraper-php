<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks\Replies;

enum Reason: string
{
    case IN_THREAD = 'in_thread';

    case MORE_REPLIES = 'more_replies';

    case NO_RECENT_REPLIES = 'no_recent_replies';

    case NOT_FOUND = 'not_found';

    case UNAVAILABLE = 'unavailable';

    case PROTECTED = 'protected';

    case SUSPENDED = 'suspended';
}
