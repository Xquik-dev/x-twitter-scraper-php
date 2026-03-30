<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\Bot;

use XTwitterScraper\Client;
use XTwitterScraper\ServiceContracts\Bot\PlatformLinksRawContract;

final class PlatformLinksRawService implements PlatformLinksRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
