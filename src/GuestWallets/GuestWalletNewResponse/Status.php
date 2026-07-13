<?php

declare(strict_types=1);

namespace XTwitterScraper\GuestWallets\GuestWalletNewResponse;

enum Status: string
{
    case CREATING = 'creating';

    case PENDING = 'pending';

    case PAID = 'paid';

    case EXPIRED = 'expired';

    case FAILED = 'failed';

    case REFUNDED = 'refunded';

    case DISPUTED = 'disputed';
}
