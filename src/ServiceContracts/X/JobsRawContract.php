<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\JobLocations;
use XTwitterScraper\PaginatedJobs;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Jobs\JobListLocationsParams;
use XTwitterScraper\X\Jobs\JobRetrieveParams;
use XTwitterScraper\X\Jobs\JobRetrieveResponse;
use XTwitterScraper\X\Jobs\JobSearchParams;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface JobsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|JobSearchParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedJobs>
     *
     * @throws APIException
     */
    public function search(
        array|JobSearchParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|JobListLocationsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<JobLocations>
     *
     * @throws APIException
     */
    public function listLocations(
        array|JobListLocationsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|JobRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<JobRetrieveResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|JobRetrieveParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
