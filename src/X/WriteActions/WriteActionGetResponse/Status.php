<?php

declare(strict_types=1);

namespace XTwitterScraper\X\WriteActions\WriteActionGetResponse;

enum Status: string
{
    case SUCCESS = 'success';

    case FAILED = 'failed';

    case PENDING_CONFIRMATION = 'pending_confirmation';
}
