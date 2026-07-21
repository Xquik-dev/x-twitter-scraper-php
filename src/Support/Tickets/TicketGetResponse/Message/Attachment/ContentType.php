<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets\TicketGetResponse\Message\Attachment;

enum ContentType: string
{
    case IMAGE_JPEG = 'image/jpeg';

    case IMAGE_PNG = 'image/png';

    case IMAGE_GIF = 'image/gif';

    case IMAGE_WEBP = 'image/webp';

    case VIDEO_MP4 = 'video/mp4';

    case VIDEO_QUICKTIME = 'video/quicktime';

    case VIDEO_WEBM = 'video/webm';
}
