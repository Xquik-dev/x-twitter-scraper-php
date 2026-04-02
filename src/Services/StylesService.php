<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\StylesContract;
use XTwitterScraper\Styles\StyleAnalyzeResponse;
use XTwitterScraper\Styles\StyleCompareResponse;
use XTwitterScraper\Styles\StyleListResponse;

/**
 * Tweet composition, drafts, writing styles & radar.
 *
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
    ): StyleAnalyzeResponse {
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
}
