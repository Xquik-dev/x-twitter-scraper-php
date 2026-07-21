<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets\TicketReplyResponse\Attachment;

enum Status: string
{
    case PENDING = 'pending';

    case READY = 'ready';

    case FAILED = 'failed';
}
