<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets\TicketListResponse\Ticket;

enum Status: string
{
    case OPEN = 'open';

    case IN_PROGRESS = 'in_progress';

    case RESOLVED = 'resolved';

    case CLOSED = 'closed';
}
