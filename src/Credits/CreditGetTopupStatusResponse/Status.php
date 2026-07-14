<?php

declare(strict_types=1);

namespace XTwitterScraper\Credits\CreditGetTopupStatusResponse;

enum Status: string
{
    case PAID = 'paid';

    case PROCESSING = 'processing';

    case FAILED = 'failed';

    case EXPIRED = 'expired';
}
