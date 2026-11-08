<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionRunResponse;

enum Status: string
{
    case PENDING = 'pending';

    case RUNNING = 'running';

    case CANCELED = 'canceled';

    case COMPLETED = 'completed';

    case FAILED = 'failed';
}
