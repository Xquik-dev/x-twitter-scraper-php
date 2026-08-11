<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\Support;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\Support\AttachmentsRawContract;
use XTwitterScraper\Support\Attachments\AttachmentDownloadParams;

/**
 * Support ticket management.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class AttachmentsRawService implements AttachmentsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Streams an authenticated user's support image or video. Video requests support one standard byte range for seeking and resumable playback.
     *
     * @param string $id Support attachment public ID
     * @param array{range?: string}|AttachmentDownloadParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<string>
     *
     * @throws APIException
     */
    public function download(
        string $id,
        array|AttachmentDownloadParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AttachmentDownloadParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['support/attachments/%1$s', $id],
            headers: Util::array_transform_keys(
                ['Accept' => 'application/octet-stream', ...$parsed],
                ['range' => 'Range'],
            ),
            options: $options,
            convert: 'string',
        );
    }
}
