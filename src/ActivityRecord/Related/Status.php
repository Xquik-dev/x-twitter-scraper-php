<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ActivityRecord\Related;

enum Status: string
{
    case COMPLETED = 'completed';

    case RUNNING = 'running';

    case FAILED = 'failed';

    case CANCELED = 'canceled';
}
