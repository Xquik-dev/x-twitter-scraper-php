<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\AccountConnectionLinks\AccountConnectionLinkDeleteResponse;
use XTwitterScraper\X\AccountConnectionLinks\AccountConnectionLinkNewResponse;
use XTwitterScraper\X\AccountConnectionLinks\XAccountConnectionLink;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface AccountConnectionLinksContract
{
    /**
     * @api
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
    ): AccountConnectionLinkNewResponse;

    /**
     * @api
     *
     * @param string $id connect link ID returned when you created the link
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): XAccountConnectionLink;

    /**
     * @api
     *
     * @param string $id connect link ID returned when you created the link
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): AccountConnectionLinkDeleteResponse;
}
