<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetAnalysisResult\Analysis\ContextAvailability;

enum Author: string
{
    case AVAILABLE = 'available';

    case MISSING = 'missing';
}
