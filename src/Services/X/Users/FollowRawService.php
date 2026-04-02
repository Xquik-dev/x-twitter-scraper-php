<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X\Users;

use XTwitterScraper\Client;
use XTwitterScraper\ServiceContracts\X\Users\FollowRawContract;

final class FollowRawService implements FollowRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
