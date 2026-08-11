<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Users\UserRetrieveVerifiedFollowersParams;

/**
 * Omit mode for resumable maximum coverage. Standard keeps legacy pagination. Coverage returns diagnostics once and rejects cursors.
 */
enum Mode: string
{
    case STANDARD = 'standard';

    case COVERAGE = 'coverage';
}
