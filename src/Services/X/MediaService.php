<?php

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
 * Media upload and download.
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
     * @param string $account X account (@username or ID) uploading media from URL
     * @param string $url HTTPS URL to download and upload as media
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function upload(
        string $account,
        string $url,
        RequestOptions|array|null $requestOptions = null,
    ): MediaUploadResponse {
        $params = Util::removeNulls(['account' => $account, 'url' => $url]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->upload(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
