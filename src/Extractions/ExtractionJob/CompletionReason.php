<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionJob;

enum CompletionReason: string
{
    case BUDGET_LIMITED = 'budget_limited';

    case CANCELED = 'canceled';

    case DEADLINE_REACHED = 'deadline_reached';

    case FAILED = 'failed';

    case PAGINATION_SAFETY_LIMIT = 'pagination_safety_limit';

    case PARTIAL_FAILURE = 'partial_failure';

    case REQUESTED_LIMIT_REACHED = 'requested_limit_reached';

    case SOURCE_EXHAUSTED = 'source_exhausted';
}
