<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Monitors\MonitorUpsertByUsernameResponse;

enum PausedReason: string
{
    case INSUFFICIENT_CREDITS = 'insufficient_credits';

    case X_ACCOUNT_PROTECTED = 'x_account_protected';

    case X_USER_NOT_FOUND = 'x_user_not_found';
}
