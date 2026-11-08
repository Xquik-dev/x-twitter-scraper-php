<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Activity\ActivityListParams\Format;
use XTwitterScraper\ActivityLogRow;
use XTwitterScraper\ActivityRecord;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\ActivityContract;

/**
 * Activity operations of the Xquik API.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class ActivityService implements ActivityContract
{
    /**
     * @api
     */
    public ActivityRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ActivityRawService($client);
    }

    /**
     * @api
     *
     * Returns the account's activity log, newest first, with the Activity page's filters. It covers write actions, extractions, monitor changes and events, webhooks, giveaways, media, support, API keys, X account connections and billing. Pick a file format to get the same rows as a CSV, Excel, Markdown, PDF or text file.
     *
     * @param Format|value-of<Format>|null $format Answer format. JSON by default.
     * @param int|null $limit Most rows to return, with no upper limit. A PDF above 10,000 rows comes as a ZIP of PDF parts.
     * @param string|null $category Activity group, like the Activity page's tabs. `all` by default, or `actions`, `extractions`, `monitors`, `webhooks` or `billing`.
     * @param string|null $status comma-separated statuses
     * @param string|null $q search text
     * @param \DateTimeInterface|null $since oldest time, ISO 8601
     * @param \DateTimeInterface|null $until newest time, ISO 8601
     * @param RequestOpts|null $requestOptions
     *
     * @return list<ActivityLogRow>
     *
     * @throws APIException
     */
    public function list(
        Format|string|null $format = null,
        ?int $limit = null,
        ?string $category = null,
        ?string $status = null,
        ?string $q = null,
        ?\DateTimeInterface $since = null,
        ?\DateTimeInterface $until = null,
        RequestOptions|array|null $requestOptions = null,
    ): array {
        $params = Util::removeNulls(
            [
                'format' => $format,
                'limit' => $limit,
                'category' => $category,
                'status' => $status,
                'q' => $q,
                'since' => $since,
                'until' => $until,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns 1 activity of the account with its full technical record. It covers every kind of activity the Activity log shows. The record holds the request, the caller, the charge, every timestamp in UTC and related activity. It never holds an API key value, a webhook secret or another account's data. Only a signed-in dashboard session sees an `api_key` record, so an API key or an OAuth app gets 404 for its ID.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null,
    ): ActivityRecord {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, requestOptions: $requestOptions);

        return $response->parse();
    }
}
