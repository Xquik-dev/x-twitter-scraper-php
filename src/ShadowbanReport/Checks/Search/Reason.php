<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks\Search;

enum Reason: string
{
    case LISTED = 'listed';

    case MISSING = 'missing';

    case NO_RECENT_POSTS = 'no_recent_posts';

    case UNAVAILABLE = 'unavailable';

    case PROTECTED = 'protected';

    case SUSPENDED = 'suspended';
}
