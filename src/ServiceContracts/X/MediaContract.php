<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Media\MediaDownloadResponse;
use XTwitterScraper\X\Media\MediaUploadResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface MediaContract
{
    /**
     * @api
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
    ): MediaDownloadResponse;

    /**
     * @api
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
    ): MediaUploadResponse;
}
