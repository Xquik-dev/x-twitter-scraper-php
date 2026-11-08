<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks\Sensitive;

enum Reason: string
{
    case NOT_FLAGGED = 'not_flagged';

    case FLAGGED = 'flagged';

    case UNKNOWN = 'unknown';

    case SUSPENDED = 'suspended';
}
