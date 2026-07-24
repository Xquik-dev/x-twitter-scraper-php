<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Draws\DrawExportParams;

/**
 * Export winners or all entries.
 */
enum Type: string
{
    case WINNERS = 'winners';

    case ENTRIES = 'entries';
}
