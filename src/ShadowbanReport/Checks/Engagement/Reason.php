<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks\Engagement;

enum Reason: string
{
    case TYPICAL = 'typical';

    case LOW = 'low';

    case TOO_FEW_POSTS = 'too_few_posts';

    case UNAVAILABLE = 'unavailable';

    case PROTECTED = 'protected';

    case SUSPENDED = 'suspended';
}
