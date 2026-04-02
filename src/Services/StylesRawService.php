<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\StylesRawContract;
use XTwitterScraper\Styles\StyleAnalyzeParams;
use XTwitterScraper\Styles\StyleAnalyzeResponse;
use XTwitterScraper\Styles\StyleCompareParams;
use XTwitterScraper\Styles\StyleCompareResponse;
use XTwitterScraper\Styles\StyleListResponse;

/**
 * Tweet composition, drafts, writing styles & radar.
 *
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
     * Analyze writing style from recent tweets
     *
     * @param array{username: string}|StyleAnalyzeParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<StyleAnalyzeResponse>
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
            convert: StyleAnalyzeResponse::class,
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
}
