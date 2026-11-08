<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Activity\ActivityListParams;
use XTwitterScraper\ActivityLogRow;
use XTwitterScraper\ActivityRecord;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Conversion\ListOf;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\ActivityRawContract;

/**
 * Activity operations of the Xquik API.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class ActivityRawService implements ActivityRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Returns the account's activity log, newest first, with the Activity page's filters. It covers write actions, extractions, monitor changes and events, webhooks, giveaways, media, support, API keys, X account connections and billing. Pick a file format to get the same rows as a CSV, Excel, Markdown, PDF or text file.
     *
     * @param array<string,mixed>|ActivityListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<list<ActivityLogRow>>
     *
     * @throws APIException
     */
    public function list(
        array|ActivityListParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ActivityListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'activity',
            query: $parsed,
            options: $options,
            convert: new ListOf(ActivityLogRow::class),
        );
    }

    /**
     * @api
     *
     * Returns 1 activity of the account with its full technical record. It covers every kind of activity the Activity log shows. The record holds the request, the caller, the charge, every timestamp in UTC and related activity. It never holds an API key value, a webhook secret or another account's data. Only a signed-in dashboard session sees an `api_key` record, so an API key or an OAuth app gets 404 for its ID.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ActivityRecord>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['activity/%1$s', $id],
            options: $requestOptions,
            convert: ActivityRecord::class,
        );
    }
}
