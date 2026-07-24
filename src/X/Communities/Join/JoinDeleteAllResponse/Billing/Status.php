<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Communities\Join\JoinDeleteAllResponse\Billing;

enum Status: string
{
    case NOT_CHARGED = 'not_charged';

    case PENDING = 'pending';

    case CHARGED = 'charged';

    case CHARGE_FAILED = 'charge_failed';

    case REFUNDED = 'refunded';
}
