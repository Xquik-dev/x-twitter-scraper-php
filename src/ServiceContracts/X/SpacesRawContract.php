<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Spaces\SpaceRetrieveParams;
use XTwitterScraper\X\Spaces\SpaceRetrieveReplayParams;
use XTwitterScraper\X\Spaces\SpaceRetrieveReplayResponse;
use XTwitterScraper\X\Spaces\SpaceRetrieveResponse;
use XTwitterScraper\X\Spaces\SpaceSearchParams;
use XTwitterScraper\X\Spaces\SpaceSearchResponse;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface SpacesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|SpaceSearchParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SpaceSearchResponse>
     *
     * @throws APIException
     */
    public function search(
        array|SpaceSearchParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SpaceRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SpaceRetrieveResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|SpaceRetrieveParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SpaceRetrieveReplayParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SpaceRetrieveReplayResponse>
     *
     * @throws APIException
     */
    public function retrieveReplay(
        string $id,
        array|SpaceRetrieveReplayParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
