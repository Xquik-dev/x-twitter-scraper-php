<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\MediaContract;
use XTwitterScraper\X\Media\MediaDownloadResponse;
use XTwitterScraper\X\Media\MediaNewResponse;

/**
 * Media upload & download.
 *
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
     * Upload media
     *
     * @param string $account X account (@username or account ID)
     * @param string $file Media file to upload
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $account,
        string $file,
        ?bool $isLongVideo = null,
        RequestOptions|array|null $requestOptions = null,
    ): MediaNewResponse {
        $params = Util::removeNulls(
            ['account' => $account, 'file' => $file, 'isLongVideo' => $isLongVideo]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Download tweet media
     *
     * @param list<string> $tweetIDs Array of tweet URLs or IDs (bulk, max 50)
     * @param string $tweetInput Tweet URL or ID (single tweet)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function download(
        ?array $tweetIDs = null,
        ?string $tweetInput = null,
        RequestOptions|array|null $requestOptions = null,
    ): MediaDownloadResponse {
        $params = Util::removeNulls(
            ['tweetIDs' => $tweetIDs, 'tweetInput' => $tweetInput]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->download(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
