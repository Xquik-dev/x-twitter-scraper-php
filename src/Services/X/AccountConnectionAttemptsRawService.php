<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\AccountConnectionAttemptsRawContract;
use XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse;
use XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionAttemptFailed;
use XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionAttemptPending;
use XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionAttemptSuccess;
use XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionChallenge;

/**
 * Connected X account management.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class AccountConnectionAttemptsRawService implements AccountConnectionAttemptsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get X account connection status
     *
     * @param string $id connection attempt ID returned by `POST /x/accounts`
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XAccountConnectionAttemptPending|XAccountConnectionAttemptSuccess|XAccountConnectionAttemptFailed|XAccountConnectionChallenge,>
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
            path: ['x/account-connection-attempts/%1$s', $id],
            options: $requestOptions,
            convert: AccountConnectionAttemptGetResponse::class,
        );
    }
}
