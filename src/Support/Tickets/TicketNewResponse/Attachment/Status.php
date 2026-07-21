<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets\TicketNewResponse\Attachment;

enum Status: string
{
    case PENDING = 'pending';

    case READY = 'ready';

    case FAILED = 'failed';
}
