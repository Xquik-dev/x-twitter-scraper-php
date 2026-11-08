<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Account\AccountGetResponse\Subscription;

enum Status: string
{
    case NONE = 'none';

    case ACTIVE = 'active';

    case PAST_DUE = 'past_due';

    case CANCELING = 'canceling';

    case INCOMPLETE = 'incomplete';
}
