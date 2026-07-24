<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Events\Event;

/**
 * Source monitor type.
 */
enum MonitorType: string
{
    case ACCOUNT = 'account';

    case KEYWORD = 'keyword';
}
