<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

enum ShadowbanVerdict: string
{
    case PASS = 'pass';

    case FAIL = 'fail';

    case UNKNOWN = 'unknown';
}
