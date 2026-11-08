<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\PostMonitor;

enum PausedReason: string
{
    case INSUFFICIENT_CREDITS = 'insufficient_credits';

    case X_POST_DELETED = 'x_post_deleted';

    case X_POST_PROTECTED = 'x_post_protected';

    case X_POST_UNAVAILABLE = 'x_post_unavailable';
}
