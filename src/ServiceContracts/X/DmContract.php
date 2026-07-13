<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Dm\DmGetHistoryResponse;
use XTwitterScraper\X\Dm\DmSendResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface DmContract
{
    /**
     * @api
     *
     * @param string $userID Target user ID
     * @param string $account X handle (without the `@` prefix) of the connected X account used to read the conversation. The account must be a participant in the conversation.
     * @param string $cursor Pagination cursor for DM history
     * @param string $maxID Legacy pagination cursor (backward compat)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveHistory(
        string $userID,
        string $account,
        ?string $cursor = null,
        ?string $maxID = null,
        RequestOptions|array|null $requestOptions = null,
    ): DmGetHistoryResponse;

    /**
     * @api
     *
     * @param string $userID Recipient user ID
     * @param string $account X account (@username or ID) sending the DM
     * @param list<string> $mediaIDs optional array containing exactly 1 uploaded media ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function send(
        string $userID,
        string $account,
        string $text,
        ?array $mediaIDs = null,
        RequestOptions|array|null $requestOptions = null,
    ): DmSendResponse;
}
