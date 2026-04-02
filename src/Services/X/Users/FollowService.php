<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X\Users;

use XTwitterScraper\Client;
use XTwitterScraper\ServiceContracts\X\Users\FollowContract;

final class FollowService implements FollowContract
{
    /**
     * @api
     */
    public FollowRawService $raw;

    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new FollowRawService($client);
    }
}
