<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Profile\ProfileUpdateAvatarResponse\Billing;

enum Status: string
{
    case NOT_CHARGED = 'not_charged';

    case PENDING = 'pending';

    case CHARGED = 'charged';

    case CHARGE_FAILED = 'charge_failed';

    case REFUNDED = 'refunded';
}
