<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks\Withheld;

enum Reason: string
{
    case NONE = 'none';

    case COUNTRIES = 'countries';

    case SUSPENDED = 'suspended';
}
