<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\AccountConnectionAttemptsContract;
use XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionAttemptFailed;
use XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionAttemptPending;
use XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionAttemptSuccess;
use XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionChallenge;

/**
 * Connected X account management.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class AccountConnectionAttemptsService implements AccountConnectionAttemptsContract
{
    /**
     * @api
     */
    public AccountConnectionAttemptsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new AccountConnectionAttemptsRawService($client);
    }

    /**
     * @api
     *
     * Get X account connection status
     *
     * @param string $id connection attempt ID returned by `POST /x/accounts`
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): XAccountConnectionAttemptPending|XAccountConnectionAttemptSuccess|XAccountConnectionAttemptFailed|XAccountConnectionChallenge {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, requestOptions: $requestOptions);

        return $response->parse();
    }
}
