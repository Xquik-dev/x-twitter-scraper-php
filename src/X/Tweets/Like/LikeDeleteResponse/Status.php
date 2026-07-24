<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\Like\LikeDeleteResponse;

enum Status: string
{
    case ACCEPTED = 'accepted';

    case DISPATCHING = 'dispatching';

    case PENDING_CONFIRMATION = 'pending_confirmation';

    case SUCCESS = 'success';

    case FAILED = 'failed';

    case EXPIRED = 'expired';
}
