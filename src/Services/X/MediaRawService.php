<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\MediaRawContract;
use XTwitterScraper\X\Media\MediaDownloadParams;
use XTwitterScraper\X\Media\MediaDownloadResponse;
use XTwitterScraper\X\Media\MediaUploadParams;
use XTwitterScraper\X\Media\MediaUploadResponse;

/**
 * Media upload & download.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class MediaRawService implements MediaRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Download tweet media
     *
     * @param array{
     *   tweetIDs?: list<string>, tweetInput?: string
     * }|MediaDownloadParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MediaDownloadResponse>
     *
     * @throws APIException
     */
    public function download(
        array|MediaDownloadParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MediaDownloadParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'x/media/download',
            body: (object) $parsed,
            options: $options,
            convert: MediaDownloadResponse::class,
        );
    }

    /**
     * @api
     *
     * Upload media
     *
     * @param array{
     *   account: string, file: string, isLongVideo?: bool
     * }|MediaUploadParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MediaUploadResponse>
     *
     * @throws APIException
     */
    public function upload(
        array|MediaUploadParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MediaUploadParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'x/media',
            headers: ['Content-Type' => 'multipart/form-data'],
            body: (object) $parsed,
            options: $options,
            convert: MediaUploadResponse::class,
        );
    }
}
