<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets\TicketGetResponse\Message\Attachment;

enum Kind: string
{
    case IMAGE = 'image';

    case VIDEO = 'video';
}
