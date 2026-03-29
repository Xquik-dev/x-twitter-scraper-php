<?php

declare(strict_types=1);

namespace XTwitterScraper\Compose\ComposeCreateParams;

/**
 * Media type (refine).
 */
enum MediaType: string
{
    case PHOTO = 'photo';

    case VIDEO = 'video';

    case NONE = 'none';
}
