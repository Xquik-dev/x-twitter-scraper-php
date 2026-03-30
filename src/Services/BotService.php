<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\ServiceContracts\BotContract;
use XTwitterScraper\Services\Bot\PlatformLinksService;

final class BotService implements BotContract
{
    /**
     * @api
     */
    public BotRawService $raw;

    /**
     * @api
     */
    public PlatformLinksService $platformLinks;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new BotRawService($client);
        $this->platformLinks = new PlatformLinksService($client);
    }
}
