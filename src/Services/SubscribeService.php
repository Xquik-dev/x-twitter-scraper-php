<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\SubscribeContract;
use XTwitterScraper\Subscribe\SubscribeNewResponse;

/**
 * Subscription & billing.
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
     * Get checkout or billing URL
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        RequestOptions|array|null $requestOptions = null
    ): SubscribeNewResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(requestOptions: $requestOptions);

        return $response->parse();
    }
}
