<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ActivityRecord;

enum Kind: string
{
    case WRITE_ACTION = 'write_action';

    case EXTRACTION = 'extraction';

    case MONITOR_CHANGE = 'monitor_change';

    case API_KEY = 'api_key';

    case BILLING = 'billing';

    case GIVEAWAY_DRAW = 'giveaway_draw';

    case MONITOR_EVENT = 'monitor_event';

    case MEDIA_DOWNLOAD = 'media_download';

    case MEDIA_SHARE = 'media_share';

    case SUPPORT_TICKET = 'support_ticket';

    case WEBHOOK_DELIVERY = 'webhook_delivery';

    case WEBHOOK_ENDPOINT = 'webhook_endpoint';

    case X_ACCOUNT_CONNECTION = 'x_account_connection';
}
