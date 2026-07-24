<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionJob;

enum Status: string
{
    case RUNNING = 'running';

    case COMPLETED = 'completed';

    case FAILED = 'failed';
}
