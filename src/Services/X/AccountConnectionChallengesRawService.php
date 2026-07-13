<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\AccountConnectionChallengesRawContract;
use XTwitterScraper\X\AccountConnectionChallenges\AccountConnectionChallengeSubmitParams;
use XTwitterScraper\X\AccountConnectionChallenges\AccountConnectionChallengeSubmitResponse;

/**
 * Connected X account management.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class AccountConnectionChallengesRawService implements AccountConnectionChallengesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Submit X account email verification code
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param array{emailCode: string}|AccountConnectionChallengeSubmitParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AccountConnectionChallengeSubmitResponse>
     *
     * @throws APIException
     */
    public function submit(
        string $id,
        array|AccountConnectionChallengeSubmitParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AccountConnectionChallengeSubmitParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['x/account-connection-challenges/%1$s/submit', $id],
            body: (object) $parsed,
            options: $options,
            convert: AccountConnectionChallengeSubmitResponse::class,
        );
    }
}
