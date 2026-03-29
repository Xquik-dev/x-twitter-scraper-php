<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Drafts\DraftCreateParams;
use XTwitterScraper\Drafts\DraftCreateParams\Goal;
use XTwitterScraper\Drafts\DraftGetResponse;
use XTwitterScraper\Drafts\DraftListParams;
use XTwitterScraper\Drafts\DraftListResponse;
use XTwitterScraper\Drafts\DraftNewResponse;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\DraftsRawContract;

/**
 * Tweet composition, drafts, writing styles & radar.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class DraftsRawService implements DraftsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Save a tweet draft
     *
     * @param array{
     *   text: string, goal?: Goal|value-of<Goal>, topic?: string
     * }|DraftCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DraftNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|DraftCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DraftCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'drafts',
            body: (object) $parsed,
            options: $options,
            convert: DraftNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Get draft by ID
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DraftGetResponse>
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
            path: ['drafts/%1$s', $id],
            options: $requestOptions,
            convert: DraftGetResponse::class,
        );
    }

    /**
     * @api
     *
     * List saved drafts
     *
     * @param array{afterCursor?: string, limit?: int}|DraftListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DraftListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|DraftListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DraftListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'drafts',
            query: $parsed,
            options: $options,
            convert: DraftListResponse::class,
        );
    }

    /**
     * @api
     *
     * Delete a draft
     *
     * @param string $id Resource ID (stringified bigint)
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
            path: ['drafts/%1$s', $id],
            options: $requestOptions,
            convert: null,
        );
    }
}
