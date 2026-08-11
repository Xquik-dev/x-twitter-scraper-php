<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Monitors\Monitor;

/**
 * Why Xquik automatically paused this monitor.
 */
enum PausedReason: string
{
    case X_USER_NOT_FOUND = 'x_user_not_found';
}
