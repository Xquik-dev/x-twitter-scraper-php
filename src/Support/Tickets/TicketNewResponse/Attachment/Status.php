<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets\TicketNewResponse\Attachment;

enum Status: string
{
    case PENDING = 'pending';

    case READY = 'ready';

    case FAILED = 'failed';
}
