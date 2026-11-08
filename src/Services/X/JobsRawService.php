<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\JobLocations;
use XTwitterScraper\PaginatedJobs;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\JobsRawContract;
use XTwitterScraper\X\Jobs\JobListLocationsParams;
use XTwitterScraper\X\Jobs\JobRetrieveParams;
use XTwitterScraper\X\Jobs\JobRetrieveResponse;
use XTwitterScraper\X\Jobs\JobSearchParams;

/**
 * Job operations of the Xquik API.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class JobsRawService implements JobsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Returns job listings with title, location, salary, company & apply link. Add filters to narrow them. A closed job does not appear & costs nothing. Follow next_cursor for more.
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
    ): BaseResponse {
        [$parsed, $options] = JobSearchParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/jobs/search',
            query: $parsed,
            options: $options,
            convert: PaginatedJobs::class,
        );
    }

    /**
     * @api
     *
     * Returns the places whose names match a query, each with the location ID that GET /x/jobs/search takes. No match returns an empty list, free.
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
    ): BaseResponse {
        [$parsed, $options] = JobListLocationsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/jobs/locations',
            query: $parsed,
            options: $options,
            convert: JobLocations::class,
        );
    }

    /**
     * @api
     *
     * Returns a public job listing with its description as text & Markdown, work type, seniority, salary, company & apply link. A job that closed returns job_not_found & is free.
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
    ): BaseResponse {
        [$parsed, $options] = JobRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/jobs/%1$s', $id],
            query: $parsed,
            options: $options,
            convert: JobRetrieveResponse::class,
        );
    }
}
