<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Communities\CommunityNewResponse\NextAction;

enum Type: string
{
    case POLL = 'poll';

    case RETRY = 'retry';

    case VERIFY_RESULT = 'verify_result';

    case FIX_REQUEST = 'fix_request';
}
