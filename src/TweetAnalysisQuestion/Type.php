<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetAnalysisQuestion;

enum Type: string
{
    case CHOICE = 'choice';

    case SCORE = 'score';

    case PROBABILITY = 'probability';
}
