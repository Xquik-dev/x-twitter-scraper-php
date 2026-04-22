<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\Styles\StyleCompareResponse;
use XTwitterScraper\Styles\StyleGetPerformanceResponse;
use XTwitterScraper\Styles\StyleListResponse;
use XTwitterScraper\Styles\StyleProfile;
use XTwitterScraper\Styles\StyleUpdateParams\Tweet;

/**
 * @phpstan-import-type TweetShape from \XTwitterScraper\Styles\StyleUpdateParams\Tweet
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface StylesContract
{
    /**
     * @api
     *
     * @param string $id Style profile ID or X username
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): StyleProfile;

    /**
     * @api
     *
     * @param string $id Style profile ID or X username
     * @param string $label Display label for the style
     * @param list<Tweet|TweetShape> $tweets Array of tweet objects
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $id,
        string $label,
        array $tweets,
        RequestOptions|array|null $requestOptions = null,
    ): StyleProfile;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): StyleListResponse;

    /**
     * @api
     *
     * @param string $id Style profile ID or X username
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param string $username X username to analyze
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function analyze(
        string $username,
        RequestOptions|array|null $requestOptions = null
    ): StyleProfile;

    /**
     * @api
     *
     * @param string $username1 First username to compare
     * @param string $username2 Second username to compare
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function compare(
        string $username1,
        string $username2,
        RequestOptions|array|null $requestOptions = null,
    ): StyleCompareResponse;

    /**
     * @api
     *
     * @param string $id Style profile ID or X username
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getPerformance(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): StyleGetPerformanceResponse;
}
