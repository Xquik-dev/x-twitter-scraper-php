<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionExportResultsParams;

enum Change: string
{
    case ADDED = 'added';

    case REMOVED = 'removed';
}
