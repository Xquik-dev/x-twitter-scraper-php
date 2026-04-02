<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\Styles\StyleAnalyzeResponse;
use XTwitterScraper\Styles\StyleCompareResponse;
use XTwitterScraper\Styles\StyleListResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface StylesContract
{
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
     * @param string $username X username to analyze
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function analyze(
        string $username,
        RequestOptions|array|null $requestOptions = null
    ): StyleAnalyzeResponse;

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
}
