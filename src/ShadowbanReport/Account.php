<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport;

enum Account: string
{
    case ACTIVE = 'active';

    case PROTECTED = 'protected';

    case SUSPENDED = 'suspended';
}
