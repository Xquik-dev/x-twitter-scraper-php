<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Communities\CommunityRetrieveSearchParams;

/**
 * Sort order (Latest or Top).
 */
enum QueryType: string
{
    case LATEST = 'Latest';

    case TOP = 'Top';
}
