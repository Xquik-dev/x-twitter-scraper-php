<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets\TicketUpdateParams;

enum Status: string
{
    case OPEN = 'open';

    case RESOLVED = 'resolved';

    case CLOSED = 'closed';
}
