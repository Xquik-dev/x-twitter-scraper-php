<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionEstimateCostParams;

/**
 * Media type used for estimate filtering (tweet_search_extractor).
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
