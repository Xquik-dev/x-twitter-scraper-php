<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionRunParams;

/**
 * Reply collection strategy.
 */
enum CollectionStrategy: string
{
    case AUTO = 'auto';

    case COMPLETE = 'complete';

    case DIRECT = 'direct';

    case SEARCH = 'search';

    case THREAD = 'thread';
}
