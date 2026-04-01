<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\APIKeys\APIKeyCreateParams;
use XTwitterScraper\APIKeys\APIKeyListResponse;
use XTwitterScraper\APIKeys\APIKeyNewResponse;
use XTwitterScraper\APIKeys\APIKeyRevokeResponse;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\APIKeysRawContract;

/**
 * API key management (session auth only).
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class APIKeysRawService implements APIKeysRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create API key
     *
     * @param array{name?: string}|APIKeyCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIKeyNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|APIKeyCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = APIKeyCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'api-keys',
            body: (object) $parsed,
            options: $options,
            convert: APIKeyNewResponse::class,
            security: ['apiKey' => true],
        );
    }

    /**
     * @api
     *
     * List API keys
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIKeyListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'api-keys',
            options: $requestOptions,
            convert: APIKeyListResponse::class,
            security: ['apiKey' => true],
        );
    }

    /**
     * @api
     *
     * Revoke API key
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIKeyRevokeResponse>
     *
     * @throws APIException
     */
    public function revoke(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['api-keys/%1$s', $id],
            options: $requestOptions,
            convert: APIKeyRevokeResponse::class,
            security: ['apiKey' => true],
        );
    }
}
