<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetAnalysisResult;

enum ViralVerdict: string
{
    case SEND_IT = 'send_it';

    case EDIT_FIRST = 'edit_first';

    case SLEEP_ON_IT = 'sleep_on_it';
}
