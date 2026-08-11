<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Accounts\XAccount;

/**
 * Derived health. `healthy` is ready. `needsReauth` needs credentials. `locked` must be unlocked on X. `suspended` is banned. `recovering` can reconnect. Wait before using `temporaryIssue`.
 */
enum Health: string
{
    case HEALTHY = 'healthy';

    case LOCKED = 'locked';

    case NEEDS_REAUTH = 'needsReauth';

    case RECOVERING = 'recovering';

    case SUSPENDED = 'suspended';

    case TEMPORARY_ISSUE = 'temporaryIssue';
}
