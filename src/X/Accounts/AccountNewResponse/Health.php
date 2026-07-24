<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Accounts\AccountNewResponse;

enum Health: string
{
    case HEALTHY = 'healthy';

    case LOCKED = 'locked';

    case NEEDS_REAUTH = 'needsReauth';

    case RECOVERING = 'recovering';

    case SUSPENDED = 'suspended';

    case TEMPORARY_ISSUE = 'temporaryIssue';
}
