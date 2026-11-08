<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\Monitors;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Monitors\Posts\PostDeleteResponse;
use XTwitterScraper\Monitors\Posts\PostListResponse;
use XTwitterScraper\PostEventType;
use XTwitterScraper\PostMonitor;
use XTwitterScraper\PostMonitorMetrics;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\Monitors\PostsContract;

/**
 * Post operations of the Xquik API.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class PostsService implements PostsContract
{
    /**
     * @api
     */
    public PostsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new PostsRawService($client);
    }

    /**
     * @api
     *
     * Returns post monitors with each post's 6 metrics, their current values & gains since tracking began.
     *
     * @param int|null $limit Maximum items per page, from 1 to 10,000. Default 200. Pass nextCursor as cursor for the next page.
     * @param string|null $cursor Previous nextCursor. The after alias also works. Offset pagination is not supported.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?int $limit = null,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): PostListResponse {
        $params = Util::removeNulls(
            [
                'limit' => $limit,
                'cursor' => $cursor,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Creates a monitor for 1 X post. It tracks replies, quotes, edits, deletion & 6 metrics, for 30 credits an hour with events & webhook deliveries included. That hourly price is a monitor's only charge. Creation needs the credits of the first hour & reads the post once.
     *
     * @param string $post Post link or ID. x.com, twitter.com, mobile & /i/web/status/ links work with any query string.
     * @param string|null $name Your own label for the post monitor. Its events carry it as monitorName.
     * @param list<PostEventType|value-of<PostEventType>>|null $eventTypes Post event types to send. Without it, a monitor sends new replies, new quotes, like & retweet changes, edits & deletion.
     * @param bool|null $isActive Send false to create the monitor paused. A paused monitor reads nothing & costs nothing until a PATCH sets isActive to true.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $post,
        ?string $name = null,
        ?array $eventTypes = null,
        ?bool $isActive = null,
        RequestOptions|array|null $requestOptions = null,
    ): PostMonitor {
        $params = Util::removeNulls(
            [
                'post' => $post,
                'name' => $name,
                'eventTypes' => $eventTypes,
                'isActive' => $isActive,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns 1 post monitor with its post & the 6 metrics, each with its current value & gain since tracking began.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null,
    ): PostMonitor {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Stops 1 post monitor, then removes its stored events & metric history in bounded batches. Poll statusUrl until the monitor returns 404.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null,
    ): PostDeleteResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Updates a post monitor's label, event types or active state. Turning a paused monitor on reads the post first, & answers 409 while X hides it.
     *
     * @param list<PostEventType|value-of<PostEventType>>|null $eventTypes Post event types to send. Without it, a monitor sends new replies, new quotes, like & retweet changes, edits & deletion.
     * @param string|null $name New label for the post monitor. Send null to remove it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $id,
        ?array $eventTypes = null,
        ?bool $isActive = null,
        ?string $name = null,
        RequestOptions|array|null $requestOptions = null,
    ): PostMonitor {
        $params = Util::removeNulls(
            [
                'eventTypes' => $eventTypes,
                'isActive' => $isActive,
                'name' => $name,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns 1 bucket per hour with each metric's value at the hour's end & its gain over that hour. The last bucket is the current hour. Hours before tracking began carry the starting values with a gain of 0.
     *
     * @param int|null $hours hours to return, from 1 to 17,520
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveMetrics(
        string $id,
        ?int $hours = null,
        RequestOptions|array|null $requestOptions = null,
    ): PostMonitorMetrics {
        $params = Util::removeNulls(
            [
                'hours' => $hours,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveMetrics($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
