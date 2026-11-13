<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Users\UserRetrieveMentionsParams;

/**
 * With replies=exclude, also leaves out replies to the author's own posts, so the search skips every reply.
 */
enum OwnThreads: string
{
    case EXCLUDE = 'exclude';
}
