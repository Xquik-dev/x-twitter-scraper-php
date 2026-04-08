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
    ): MediaDownloadResponse;

    /**
     * @api
     *
     * @param string $account X account (@username or ID) uploading media
     * @param string $file Media file to upload
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function upload(
        string $account,
        string $file,
        ?bool $isLongVideo = null,
        RequestOptions|array|null $requestOptions = null,
    ): MediaUploadResponse;
}
