<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Account\AccountGetResponse;

enum Plan: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
