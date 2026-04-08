<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\StylesRawContract;
use XTwitterScraper\Styles\StyleAnalyzeParams;
use XTwitterScraper\Styles\StyleCompareParams;
use XTwitterScraper\Styles\StyleCompareResponse;
use XTwitterScraper\Styles\StyleGetPerformanceResponse;
use XTwitterScraper\Styles\StyleListResponse;
use XTwitterScraper\Styles\StyleProfile;
use XTwitterScraper\Styles\StyleUpdateParams;
use XTwitterScraper\Styles\StyleUpdateParams\Tweet;

/**
 * Tweet composition, drafts, writing styles & radar.
 *
 * @phpstan-import-type TweetShape from \XTwitterScraper\Styles\StyleUpdateParams\Tweet
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class StylesRawService implements StylesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get cached style profile
     *
     * @param string $id Style profile ID or X username
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<StyleProfile>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['styles/%1$s', $id],
            options: $requestOptions,
            convert: StyleProfile::class,
        );
    }

    /**
     * @api
     *
     * Save style profile with custom tweets
     *
     * @param string $id Style profile ID or X username
     * @param array{
     *   label: string, tweets: list<Tweet|TweetShape>
     * }|StyleUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<StyleProfile>
     *
     * @throws APIException
     */
    public function update(
        string $id,
        array|StyleUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = StyleUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'put',
            path: ['styles/%1$s', $id],
            body: (object) $parsed,
            options: $options,
            convert: StyleProfile::class,
        );
    }

    /**
     * @api
     *
     * List cached style profiles
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<StyleListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'styles',
            options: $requestOptions,
            convert: StyleListResponse::class,
        );
    }

    /**
     * @api
     *
     * Delete a style profile
     *
     * @param string $id Style profile ID or X username
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['styles/%1$s', $id],
            options: $requestOptions,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Analyze writing style from recent tweets
     *
     * @param array{username: string}|StyleAnalyzeParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<StyleProfile>
     *
     * @throws APIException
     */
    public function analyze(
        array|StyleAnalyzeParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = StyleAnalyzeParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'styles',
            body: (object) $parsed,
            options: $options,
            convert: StyleProfile::class,
        );
    }

    /**
     * @api
     *
     * Compare two style profiles
     *
     * @param array{username1: string, username2: string}|StyleCompareParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<StyleCompareResponse>
     *
     * @throws APIException
     */
    public function compare(
        array|StyleCompareParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = StyleCompareParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'styles/compare',
            query: $parsed,
            options: $options,
            convert: StyleCompareResponse::class,
        );
    }

    /**
     * @api
     *
     * Get engagement metrics for style tweets
     *
     * @param string $id Style profile ID or X username
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<StyleGetPerformanceResponse>
     *
     * @throws APIException
     */
    public function getPerformance(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['styles/%1$s/performance', $id],
            options: $requestOptions,
            convert: StyleGetPerformanceResponse::class,
        );
    }
}
