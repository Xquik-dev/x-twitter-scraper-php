<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\FollowersContract;
use XTwitterScraper\X\Followers\FollowerGetCheckResponse;

/**
 * X data lookups (subscription required).
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class FollowersService implements FollowersContract
{
    /**
     * @api
     */
    public FollowersRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new FollowersRawService($client);
    }

    /**
     * @api
     *
     * Check follow relationship
     *
     * @param string $source Username to check (without @)
     * @param string $target Target username (without @)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveCheck(
        string $source,
        string $target,
        RequestOptions|array|null $requestOptions = null,
    ): FollowerGetCheckResponse {
        $params = Util::removeNulls(['source' => $source, 'target' => $target]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveCheck(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
