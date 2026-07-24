<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Webhooks\Webhook;

/**
 * Endpoint delivery state. needs_attention means delivery stopped after repeated failures.
 */
enum DeliveryStatus: string
{
    case ACTIVE = 'active';

    case PAUSED = 'paused';

    case NEEDS_ATTENTION = 'needs_attention';
}
