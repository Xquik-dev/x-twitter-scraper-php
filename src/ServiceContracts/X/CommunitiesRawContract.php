<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Communities\CommunityCreateParams;
use XTwitterScraper\X\Communities\CommunityDeleteParams;
use XTwitterScraper\X\Communities\CommunityDeleteResponse;
use XTwitterScraper\X\Communities\CommunityGetInfoResponse;
use XTwitterScraper\X\Communities\CommunityNewResponse;
use XTwitterScraper\X\Communities\CommunityRetrieveMembersParams;
use XTwitterScraper\X\Communities\CommunityRetrieveModeratorsParams;
use XTwitterScraper\X\Communities\CommunityRetrieveSearchParams;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface CommunitiesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|CommunityCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CommunityNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|CommunityCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param array<string,mixed>|CommunityDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CommunityDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        array|CommunityDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Community ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CommunityGetInfoResponse>
     *
     * @throws APIException
     */
    public function retrieveInfo(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Community ID
     * @param array<string,mixed>|CommunityRetrieveMembersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function retrieveMembers(
        string $id,
        array|CommunityRetrieveMembersParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Community ID
     * @param array<string,mixed>|CommunityRetrieveModeratorsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function retrieveModerators(
        string $id,
        array|CommunityRetrieveModeratorsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|CommunityRetrieveSearchParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function retrieveSearch(
        array|CommunityRetrieveSearchParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
