<?php

declare(strict_types=1);

namespace XTwitterScraper\Radar\RadarRetrieveTrendingTopicsParams;

/**
 * Source filter. One of: github, google_trends, hacker_news, polymarket, reddit, trustmrr, wikipedia.
 */
enum Source: string
{
    case GITHUB = 'github';

    case GOOGLE_TRENDS = 'google_trends';

    case HACKER_NEWS = 'hacker_news';

    case POLYMARKET = 'polymarket';

    case REDDIT = 'reddit';

    case TRUSTMRR = 'trustmrr';

    case WIKIPEDIA = 'wikipedia';
}
