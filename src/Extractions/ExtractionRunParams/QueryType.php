<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionRunParams;

/**
 * Search ranking applied to every query.
 */
enum QueryType: string
{
    case LATEST = 'Latest';

    case TOP = 'Top';

    case BOTH = 'Both';
}
