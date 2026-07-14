<?php

declare(strict_types=1);

namespace XTwitterScraper\X\XGetNotificationsParams;

/**
 * Notification type filter. Unrecognized values fall back to All.
 */
enum Type: string
{
    case ALL = 'All';

    case VERIFIED = 'Verified';

    case MENTIONS = 'Mentions';
}
