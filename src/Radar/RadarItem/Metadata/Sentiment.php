<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Radar\RadarItem\Metadata;

enum Sentiment: string
{
    case POSITIVE = 'positive';

    case NEUTRAL = 'neutral';

    case NEGATIVE = 'negative';
}
