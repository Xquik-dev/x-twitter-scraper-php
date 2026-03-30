<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\Bot;

use XTwitterScraper\Client;
use XTwitterScraper\ServiceContracts\Bot\PlatformLinksContract;

final class PlatformLinksService implements PlatformLinksContract
{
    /**
     * @api
     */
    public PlatformLinksRawService $raw;

    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new PlatformLinksRawService($client);
    }
}
