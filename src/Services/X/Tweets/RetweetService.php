<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X\Tweets;

use XTwitterScraper\Client;
use XTwitterScraper\ServiceContracts\X\Tweets\RetweetContract;

final class RetweetService implements RetweetContract
{
    /**
     * @api
     */
    public RetweetRawService $raw;

    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new RetweetRawService($client);
    }
}
