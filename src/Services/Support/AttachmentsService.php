<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\Support;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\Support\AttachmentsContract;

/**
 * Support ticket management.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class AttachmentsService implements AttachmentsContract
{
    /**
     * @api
     */
    public AttachmentsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new AttachmentsRawService($client);
    }

    /**
     * @api
     *
     * Streams an authenticated user's support image or video. Video requests support one standard byte range for seeking and resumable playback.
     *
     * @param string $id Support attachment public ID
     * @param string $range Optional single byte range
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function download(
        string $id,
        ?string $range = null,
        RequestOptions|array|null $requestOptions = null,
    ): string {
        $params = Util::removeNulls(['range' => $range]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->download($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
