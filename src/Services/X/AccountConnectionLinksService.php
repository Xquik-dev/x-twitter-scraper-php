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
use XTwitterScraper\ServiceContracts\X\AccountConnectionLinksContract;
use XTwitterScraper\X\AccountConnectionLinks\AccountConnectionLinkDeleteResponse;
use XTwitterScraper\X\AccountConnectionLinks\AccountConnectionLinkNewResponse;
use XTwitterScraper\X\AccountConnectionLinks\XAccountConnectionLink;

/**
 * Connected X account management.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class AccountConnectionLinksService implements AccountConnectionLinksContract
{
    /**
     * @api
     */
    public AccountConnectionLinksRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new AccountConnectionLinksRawService($client);
    }

    /**
     * @api
     *
     * Create X account connect link
     *
     * @param string $accountID The ID of 1 of your X accounts. The link then reconnects that account.
     * @param string $reference Your own ID for this person. It comes back when you read the link.
     * @param string $returnURL A public https URL the page offers as a button once the account connects. Xquik never redirects by itself, & never adds the token.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?string $accountID = null,
        ?string $reference = null,
        ?string $returnURL = null,
        RequestOptions|array|null $requestOptions = null,
    ): AccountConnectionLinkNewResponse {
        $params = Util::removeNulls(
            [
                'accountID' => $accountID,
                'reference' => $reference,
                'returnURL' => $returnURL,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get X account connect link
     *
     * @param string $id connect link ID returned when you created the link
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): XAccountConnectionLink {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Revoke X account connect link
     *
     * @param string $id connect link ID returned when you created the link
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): AccountConnectionLinkDeleteResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($id, requestOptions: $requestOptions);

        return $response->parse();
    }
}
