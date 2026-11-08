<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

enum FollowerClass: string
{
    case AUTOMATED = 'automated';

    case INACTIVE = 'inactive';

    case LIKELY_FAKE = 'likelyFake';

    case LIKELY_REAL = 'likelyReal';

    case TOO_NEW = 'tooNew';
}
