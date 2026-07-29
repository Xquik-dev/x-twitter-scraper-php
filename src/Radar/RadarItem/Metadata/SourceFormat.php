<?php

declare(strict_types=1);

namespace XTwitterScraper\Radar\RadarItem\Metadata;

/**
 * Current items use html. json and rss are retained for legacy rows.
 */
enum SourceFormat: string
{
    case HTML = 'html';

    case JSON = 'json';

    case RSS = 'rss';
}
