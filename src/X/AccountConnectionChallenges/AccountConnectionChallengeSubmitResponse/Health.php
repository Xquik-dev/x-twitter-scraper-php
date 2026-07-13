<?php

declare(strict_types=1);

namespace XTwitterScraper\X\AccountConnectionChallenges\AccountConnectionChallengeSubmitResponse;

enum Health: string
{
    case HEALTHY = 'healthy';

    case LOCKED = 'locked';

    case NEEDS_REAUTH = 'needsReauth';

    case RECOVERING = 'recovering';

    case SUSPENDED = 'suspended';

    case TEMPORARY_ISSUE = 'temporaryIssue';
}
