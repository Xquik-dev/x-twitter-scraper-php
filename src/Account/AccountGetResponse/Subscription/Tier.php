<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Account\AccountGetResponse\Subscription;

enum Tier: string
{
    case STARTER = 'starter';

    case PRO = 'pro';

    case BUSINESS = 'business';
}
