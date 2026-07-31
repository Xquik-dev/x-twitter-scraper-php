<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets\TicketUpdateResponse;

enum Status: string
{
    case OPEN = 'open';

    case RESOLVED = 'resolved';

    case CLOSED = 'closed';
}
