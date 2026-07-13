<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\SubscribeRawContract;
use XTwitterScraper\Subscribe\SubscribeCreateParams;
use XTwitterScraper\Subscribe\SubscribeCreateParams\Tier;
use XTwitterScraper\Subscribe\SubscribeNewResponse;

/**
 * Subscription, billing, and credits.
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
     * Create a subscription checkout or billing-management URL only after the user confirms. The request never completes payment by itself.
     *
     * @param array{tier?: Tier|value-of<Tier>}|SubscribeCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SubscribeNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|SubscribeCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SubscribeCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'subscribe',
            body: (object) $parsed,
            options: $options,
            convert: SubscribeNewResponse::class,
        );
    }
}
