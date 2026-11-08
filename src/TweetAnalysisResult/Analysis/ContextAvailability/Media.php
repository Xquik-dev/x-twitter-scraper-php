<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetAnalysisResult\Analysis\ContextAvailability;

enum Media: string
{
    case IMAGES = 'images';

    case TEXT_DESCRIPTIONS_ONLY = 'text_descriptions_only';

    case NOT_SUPPLIED = 'not_supplied';
}
