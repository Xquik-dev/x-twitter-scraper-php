<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\PostMonitor;

enum AuthorVerified: string
{
    case BLUE = 'blue';

    case BUSINESS = 'business';

    case GOVERNMENT = 'government';
}
