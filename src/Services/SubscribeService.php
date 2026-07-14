<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\SubscribeContract;
use XTwitterScraper\Subscribe\SubscribeCreateParams\Tier;
use XTwitterScraper\Subscribe\SubscribeNewResponse;

/**
 * Subscription, billing, and credits.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class SubscribeService implements SubscribeContract
{
    /**
     * @api
     */
    public SubscribeRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new SubscribeRawService($client);
    }

    /**
     * @api
     *
     * Create a subscription checkout or billing-management URL only after the user confirms. The request never completes payment by itself.
     *
     * @param Tier|value-of<Tier> $tier subscription tier to pre-select
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        Tier|string|null $tier = null,
        RequestOptions|array|null $requestOptions = null
    ): SubscribeNewResponse {
        $params = Util::removeNulls(['tier' => $tier]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
