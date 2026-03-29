<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\SubscribeRawContract;
use XTwitterScraper\Subscribe\SubscribeNewResponse;

/**
 * Subscription & billing.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class SubscribeRawService implements SubscribeRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get checkout or billing URL
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SubscribeNewResponse>
     *
     * @throws APIException
     */
    public function create(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'subscribe',
            options: $requestOptions,
            convert: SubscribeNewResponse::class,
        );
    }
}
