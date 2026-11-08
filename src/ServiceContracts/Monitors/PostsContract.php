<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\Monitors;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Monitors\Posts\PostDeleteResponse;
use XTwitterScraper\Monitors\Posts\PostListResponse;
use XTwitterScraper\PostEventType;
use XTwitterScraper\PostMonitor;
use XTwitterScraper\PostMonitorMetrics;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface PostsContract
{
    /**
     * @api
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
    ): PostListResponse;

    /**
     * @api
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
    ): PostMonitor;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null,
    ): PostMonitor;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null,
    ): PostDeleteResponse;

    /**
     * @api
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
    ): PostMonitor;

    /**
     * @api
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
    ): PostMonitorMetrics;
}
