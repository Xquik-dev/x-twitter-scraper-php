<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Monitors\Keywords\KeywordGetResponse;

enum PausedReason: string
{
    case INSUFFICIENT_CREDITS = 'insufficient_credits';
}
