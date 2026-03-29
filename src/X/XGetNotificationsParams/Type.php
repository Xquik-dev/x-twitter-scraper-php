<?php

declare(strict_types=1);

namespace XTwitterScraper\X\XGetNotificationsParams;

/**
 * Notification type filter.
 */
enum Type: string
{
    case ALL = 'All';

    case VERIFIED = 'Verified';

    case MENTIONS = 'Mentions';
}
