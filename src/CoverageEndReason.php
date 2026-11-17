<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

/**
 * Present on a last page that X cut short. `stalled` means X returned no new results 2 times in a row, 30 s apart. The list may hold more. Read it again later without cursor.
 */
enum CoverageEndReason: string
{
    case STALLED = 'stalled';
}
