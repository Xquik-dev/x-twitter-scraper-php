<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets\TicketGetResponse\Message\Attachment;

/**
 * Storage processing state.
 */
enum Status: string
{
    case PENDING = 'pending';

    case READY = 'ready';

    case FAILED = 'failed';
}
