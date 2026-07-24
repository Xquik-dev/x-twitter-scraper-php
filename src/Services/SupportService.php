<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\ServiceContracts\SupportContract;
use XTwitterScraper\Services\Support\TicketsService;

final class SupportService implements SupportContract
{
    /**
     * @api
     */
    public SupportRawService $raw;

    /**
     * @api
     */
    public TicketsService $tickets;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new SupportRawService($client);
        $this->tickets = new TicketsService($client);
    }
}
