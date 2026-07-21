<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Users\Follow\FollowDeleteAllResponse;

enum Status: string
{
    case ACCEPTED = 'accepted';

    case DISPATCHING = 'dispatching';

    case PENDING_CONFIRMATION = 'pending_confirmation';

    case SUCCESS = 'success';

    case FAILED = 'failed';

    case EXPIRED = 'expired';
}
