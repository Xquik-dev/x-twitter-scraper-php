<?php

declare(strict_types=1);

namespace XTwitterScraper\Events\Event;

/**
 * Source monitor type.
 */
enum MonitorType: string
{
    case ACCOUNT = 'account';

    case KEYWORD = 'keyword';
}
