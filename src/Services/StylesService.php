<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\StylesContract;
use XTwitterScraper\Styles\StyleCompareResponse;
use XTwitterScraper\Styles\StyleGetPerformanceResponse;
use XTwitterScraper\Styles\StyleListResponse;
use XTwitterScraper\Styles\StyleProfile;
use XTwitterScraper\Styles\StyleUpdateParams\Tweet;

/**
 * Tweet composition, drafts, writing styles & radar.
 *
 * @phpstan-import-type TweetShape from \XTwitterScraper\Styles\StyleUpdateParams\Tweet
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class StylesService implements StylesContract
{
    /**
     * @api
     */
    public StylesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new StylesRawService($client);
    }

    /**
     * @api
     *
     * Get cached style profile
     *
     * @param string $id Style profile ID or X username
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): StyleProfile {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Save style profile with custom tweets
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
    ): StyleProfile {
        $params = Util::removeNulls(['label' => $label, 'tweets' => $tweets]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List cached style profiles
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): StyleListResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete a style profile
     *
     * @param string $id Style profile ID or X username
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Analyze writing style from recent tweets
     *
     * @param string $username X username to analyze
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function analyze(
        string $username,
        RequestOptions|array|null $requestOptions = null
    ): StyleProfile {
        $params = Util::removeNulls(['username' => $username]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->analyze(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Compare two style profiles
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
    ): StyleCompareResponse {
        $params = Util::removeNulls(
            ['username1' => $username1, 'username2' => $username2]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->compare(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get engagement metrics for style tweets
     *
     * @param string $id Style profile ID or X username
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getPerformance(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): StyleGetPerformanceResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getPerformance($id, requestOptions: $requestOptions);

        return $response->parse();
    }
}
