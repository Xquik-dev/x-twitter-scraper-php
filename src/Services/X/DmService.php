<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\DmContract;
use XTwitterScraper\X\Dm\DmGetHistoryResponse;
use XTwitterScraper\X\Dm\DmUpdateResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class DmService implements DmContract
{
    /**
     * @api
     */
    public DmRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new DmRawService($client);
    }

    /**
     * @api
     *
     * Send direct message
     *
     * @param string $userID Recipient user ID
     * @param string $account X account (@username or account ID)
     * @param list<string> $mediaIDs
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $userID,
        string $account,
        string $text,
        ?array $mediaIDs = null,
        ?string $replyToMessageID = null,
        RequestOptions|array|null $requestOptions = null,
    ): DmUpdateResponse {
        $params = Util::removeNulls(
            [
                'account' => $account,
                'text' => $text,
                'mediaIDs' => $mediaIDs,
                'replyToMessageID' => $replyToMessageID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($userID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get DM conversation history
     *
     * @param string $userID Target user ID
     * @param string $cursor Pagination cursor from previous response
     * @param string $maxID Legacy pagination cursor (backward compat)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveHistory(
        string $userID,
        ?string $cursor = null,
        ?string $maxID = null,
        RequestOptions|array|null $requestOptions = null,
    ): DmGetHistoryResponse {
        $params = Util::removeNulls(['cursor' => $cursor, 'maxID' => $maxID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveHistory($userID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
