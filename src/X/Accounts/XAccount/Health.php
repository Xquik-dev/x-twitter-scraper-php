<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Accounts\XAccount;

/**
 * Derived login/cookie health. `healthy` = cookies valid. `needsReauth` = user must submit fresh credentials. `locked` = X locked the account; unlock on x.com first. `suspended` = X banned the account. `recovering` = past cooldown, will auto-retry on next use. `temporaryIssue` = transient backend problem; retry shortly.
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
