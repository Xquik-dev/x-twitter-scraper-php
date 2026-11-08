<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetAnalysisComparison;

enum Status: string
{
    case FIRST_RUN = 'first_run';

    case NEW_TO_BASELINE = 'new_to_baseline';

    case UNCHANGED = 'unchanged';

    case CHANGED = 'changed';

    case NOT_COMPARABLE = 'not_comparable';

    case ANALYSIS_UNAVAILABLE = 'analysis_unavailable';
}
