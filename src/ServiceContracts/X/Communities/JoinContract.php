<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X\Communities;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Communities\Join\JoinDeleteAllResponse;
use XTwitterScraper\X\Communities\Join\JoinNewResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface JoinContract
{
    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param string $account X account (@username or account ID)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $id,
        string $account,
        RequestOptions|array|null $requestOptions = null,
    ): JoinNewResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param string $account X account (@username or account ID)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function deleteAll(
        string $id,
        string $account,
        RequestOptions|array|null $requestOptions = null,
    ): JoinDeleteAllResponse;
}
