<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Media\MediaUploadResponse\Result;

enum Type: string
{
    case TWEET = 'tweet';

    case DIRECT_MESSAGE = 'direct_message';

    case MEDIA = 'media';

    case COMMUNITY = 'community';

    case STATE_CHANGE = 'state_change';
}
