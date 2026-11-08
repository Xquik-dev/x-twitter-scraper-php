<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X\Communities;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\PaginatedTweets2;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\Communities\MediaRawContract;
use XTwitterScraper\X\Communities\Media\MediaListParams;

/**
 * Media operations of the Xquik API.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
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
     * Returns the tweets with photos or videos on 1 community's Media tab, newest first. Each tweet costs 1 credit.
     *
     * @param array<string,mixed>|MediaListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets2>
     *
     * @throws APIException
     */
    public function list(
        string $id,
        array|MediaListParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MediaListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/communities/%1$s/media', $id],
            query: $parsed,
            options: $options,
            convert: PaginatedTweets2::class,
        );
    }
}
