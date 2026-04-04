<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X\Tweets;

use XTwitterScraper\Client;
use XTwitterScraper\ServiceContracts\X\Tweets\LikeContract;

final class LikeService implements LikeContract
{
    /**
     * @api
     */
    public LikeRawService $raw;

    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new LikeRawService($client);
    }
}
