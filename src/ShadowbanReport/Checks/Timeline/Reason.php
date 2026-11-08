<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks\Timeline;

enum Reason: string
{
    case VISIBLE = 'visible';

    case HIDDEN = 'hidden';

    case NO_POSTS = 'no_posts';

    case UNAVAILABLE = 'unavailable';

    case PROTECTED = 'protected';

    case SUSPENDED = 'suspended';
}
