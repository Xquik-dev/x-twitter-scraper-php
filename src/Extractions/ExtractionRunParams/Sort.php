<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionRunParams;

/**
 * Reply result order.
 */
enum Sort: string
{
    case RELEVANCE = 'relevance';

    case LATEST = 'latest';

    case OLDEST = 'oldest';

    case LIKES = 'likes';
}
