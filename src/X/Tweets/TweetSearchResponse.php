<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Concerns\SdkUnion;
use XTwitterScraper\Core\Conversion\Contracts\Converter;
use XTwitterScraper\Core\Conversion\Contracts\ConverterSource;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\X\Tweets\TweetSearchResponse\TweetSearchCoverageResponse;

/**
 * No-mode search, user Tweet, user reply, and direct reply reads use automatic coverage. Shape, filters, aliases, and billing stay compatible. Unprefixed cursors remain legacy. Follow next_cursor while has_next_page is true. An empty filtered page can still have has_next_page true.
 *
 * @phpstan-import-type PaginatedTweetsShape from \XTwitterScraper\PaginatedTweets
 * @phpstan-import-type TweetSearchCoverageResponseShape from \XTwitterScraper\X\Tweets\TweetSearchResponse\TweetSearchCoverageResponse
 *
 * @phpstan-type TweetSearchResponseVariants = PaginatedTweets|TweetSearchCoverageResponse
 * @phpstan-type TweetSearchResponseShape = TweetSearchResponseVariants|PaginatedTweetsShape|TweetSearchCoverageResponseShape
 */
final class TweetSearchResponse implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [PaginatedTweets::class, TweetSearchCoverageResponse::class];
    }
}
