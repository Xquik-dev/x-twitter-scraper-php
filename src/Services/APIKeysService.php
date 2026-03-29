<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\APIKeys\APIKeyListResponse;
use XTwitterScraper\APIKeys\APIKeyNewResponse;
use XTwitterScraper\APIKeys\APIKeyRevokeResponse;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\APIKeysContract;

/**
 * API key management (session auth only).
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class APIKeysService implements APIKeysContract
{
    /**
     * @api
     */
    public APIKeysRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new APIKeysRawService($client);
    }

    /**
     * @api
     *
     * Create API key
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?string $name = null,
        RequestOptions|array|null $requestOptions = null
    ): APIKeyNewResponse {
        $params = Util::removeNulls(['name' => $name]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List API keys
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): APIKeyListResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Revoke API key
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function revoke(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): APIKeyRevokeResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->revoke($id, requestOptions: $requestOptions);

        return $response->parse();
    }
}
