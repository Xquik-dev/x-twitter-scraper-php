<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\AccountConnectionChallengesContract;
use XTwitterScraper\X\AccountConnectionChallenges\AccountConnectionChallengeSubmitResponse;

/**
 * Connected X account management.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class AccountConnectionChallengesService implements AccountConnectionChallengesContract
{
    /**
     * @api
     */
    public AccountConnectionChallengesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new AccountConnectionChallengesRawService($client);
    }

    /**
     * @api
     *
     * Submit X account email verification code
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param string $emailCode code sent to the account email
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function submit(
        string $id,
        string $emailCode,
        RequestOptions|array|null $requestOptions = null,
    ): AccountConnectionChallengeSubmitResponse {
        $params = Util::removeNulls(['emailCode' => $emailCode]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->submit($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
