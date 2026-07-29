<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Accounts\XAccount;

/**
 * Derived connection health. `healthy` = ready to use. `needsReauth` = user must submit fresh credentials. `locked` = X locked the account; unlock on x.com first. `suspended` = X banned the account. `recovering` = cooldown ended; the account can reconnect on its next use. `temporaryIssue` = temporary connection problem; wait before the next use.
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
