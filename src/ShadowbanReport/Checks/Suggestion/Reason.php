<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks\Suggestion;

enum Reason: string
{
    case SUGGESTED = 'suggested';

    case NOT_SUGGESTED = 'not_suggested';

    case UNAVAILABLE = 'unavailable';

    case SUSPENDED = 'suspended';
}
