<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Users\UserRetrieveTweetsParams;

/**
 * Filter by media type.
 */
enum MediaType: string
{
    case IMAGES = 'images';

    case VIDEOS = 'videos';

    case GIFS = 'gifs';

    case MEDIA = 'media';

    case LINKS = 'links';

    case NONE = 'none';
}
