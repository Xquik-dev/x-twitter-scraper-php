<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Spaces\SpaceSearchParams;

enum QueryType: string
{
    case LATEST = 'Latest';

    case TOP = 'Top';

    case LIVE = 'Live';

    case UPCOMING = 'Upcoming';
}
