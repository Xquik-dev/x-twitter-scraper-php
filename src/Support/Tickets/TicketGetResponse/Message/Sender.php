<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets\TicketGetResponse\Message;

enum Sender: string
{
    case USER = 'user';

    case SUPPORT = 'support';

    case SYSTEM = 'system';
}
