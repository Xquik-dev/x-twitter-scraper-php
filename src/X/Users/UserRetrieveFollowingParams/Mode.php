<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Users\UserRetrieveFollowingParams;

/**
 * Omit mode for resumable maximum coverage. Standard keeps legacy pagination. Coverage returns diagnostics once and rejects cursors.
 */
enum Mode: string
{
    case STANDARD = 'standard';

    case COVERAGE = 'coverage';
}
