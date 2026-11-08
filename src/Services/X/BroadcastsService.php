<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\BroadcastsContract;
use XTwitterScraper\X\Broadcasts\BroadcastRetrieveResponse;

/**
 * Broadcast operations of the Xquik API.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class BroadcastsService implements BroadcastsContract
{
    /**
     * @api
     */
    public BroadcastsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new BroadcastsRawService($client);
    }

    /**
     * @api
     *
     * Returns 1 X broadcast, the live video X hosts at x.com/i/broadcasts, live or ended. Accepts the broadcast ID or the URL-encoded broadcast URL. Reading a broadcast adds no view to it.
     *
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): BroadcastRetrieveResponse {
        $params = Util::removeNulls(
            [
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
