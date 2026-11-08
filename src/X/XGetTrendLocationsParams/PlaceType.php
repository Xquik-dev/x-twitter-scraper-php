<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\XGetTrendLocationsParams;

enum PlaceType: string
{
    case COUNTRY = 'country';

    case TOWN = 'town';

    case WORLDWIDE = 'worldwide';

    case UNKNOWN = 'unknown';
}
