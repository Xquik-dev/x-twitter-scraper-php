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
use XTwitterScraper\ServiceContracts\X\MediaContract;
use XTwitterScraper\X\Media\MediaDownloadResponse;
use XTwitterScraper\X\Media\MediaUploadResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class MediaService implements MediaContract
{
    /**
     * @api
     */
    public MediaRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new MediaRawService($client);
    }

    /**
     * @api
     *
     * Download images and videos from tweets
     *
     * @param string $tweetID Numeric tweet ID alias for tweetInput
     * @param list<string> $tweetIDs Array of tweet URLs or IDs (bulk, max 50 string items)
     * @param string $tweetInput Tweet URL or ID (single tweet)
     * @param string $tweetURL Tweet URL alias for tweetInput
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function download(
        ?string $tweetID = null,
        ?array $tweetIDs = null,
        ?string $tweetInput = null,
        ?string $tweetURL = null,
        RequestOptions|array|null $requestOptions = null,
    ): MediaDownloadResponse {
        $params = Util::removeNulls(
            [
                'tweetID' => $tweetID,
                'tweetIDs' => $tweetIDs,
                'tweetInput' => $tweetInput,
                'tweetURL' => $tweetURL,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->download(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Upload media
     *
     * @param string $account Body param: X account (@username or ID) uploading media from URL
     * @param string $url Body param: HTTPS URL to download and upload as media
     * @param string $idempotencyKey Header param: Generate one unique value for each intended write. Reuse it only when retrying the exact same account, action, target, and payload. A reused key returns the original action. Reusing it with different input returns 409. Replay protection remains active for at least 90 days.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function upload(
        string $account,
        string $url,
        string $idempotencyKey,
        RequestOptions|array|null $requestOptions = null,
    ): MediaUploadResponse {
        $params = Util::removeNulls(
            [
                'account' => $account,
                'url' => $url,
                'idempotencyKey' => $idempotencyKey,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->upload(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
