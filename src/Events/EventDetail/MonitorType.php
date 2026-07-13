<?php

declare(strict_types=1);

namespace XTwitterScraper\Events\EventDetail;

/**
 * Source monitor type for this detailed event.
 */
enum MonitorType: string
{
    case ACCOUNT = 'account';

    case KEYWORD = 'keyword';
}
