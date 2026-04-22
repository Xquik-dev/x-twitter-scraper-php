<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetDetail\Media;

enum Type: string
{
    case PHOTO = 'photo';

    case VIDEO = 'video';

    case ANIMATED_GIF = 'animated_gif';
}
