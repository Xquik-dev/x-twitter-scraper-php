<?php

declare(strict_types=1);

namespace XTwitterScraper\X\WriteActions\WriteActionGetResponse\Media;

enum Kind: string
{
    case NONE = 'none';

    case IMAGE = 'image';

    case VIDEO = 'video';
}
