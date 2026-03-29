<?php

declare(strict_types=1);

namespace XTwitterScraper\Account\AccountGetResponse;

enum Plan: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
