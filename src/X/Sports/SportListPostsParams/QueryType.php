<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Sports\SportListPostsParams;

enum QueryType: string
{
    case TOP = 'Top';

    case LATEST = 'Latest';
}
