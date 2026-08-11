<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Users\UserGetVerifiedFollowersResponse\UserListCoverageResponse\Diagnostic\Strategy;

enum StopReason: string
{
    case CURSOR_FAILURE = 'cursor_failure';

    case DEADLINE = 'deadline';

    case EXHAUSTED = 'exhausted';

    case FAILED = 'failed';

    case PAGE_LIMIT = 'page_limit';

    case RESULT_LIMIT = 'result_limit';

    case STALLED = 'stalled';
}
