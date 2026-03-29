<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Media\MediaDownloadResponse;
use XTwitterScraper\X\Media\MediaNewResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface MediaContract
{
    /**
     * @api
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
    ): MediaNewResponse;

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
}
