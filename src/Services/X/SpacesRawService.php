<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\SpacesRawContract;
use XTwitterScraper\X\Spaces\SpaceRetrieveParams;
use XTwitterScraper\X\Spaces\SpaceRetrieveReplayParams;
use XTwitterScraper\X\Spaces\SpaceRetrieveReplayResponse;
use XTwitterScraper\X\Spaces\SpaceRetrieveResponse;
use XTwitterScraper\X\Spaces\SpaceSearchParams;
use XTwitterScraper\X\Spaces\SpaceSearchResponse;

/**
 * Space operations of the Xquik API.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class SpacesRawService implements SpacesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Returns public Spaces, each once, with the fields of GET /x/spaces/{id}. Latest & Top find live, scheduled or ended Spaces & accept X search operators. Live & Upcoming find live or scheduled Spaces by title words. Costs 1 credit per Space.
     *
     * @param array<string,mixed>|SpaceSearchParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SpaceSearchResponse>
     *
     * @throws APIException
     */
    public function search(
        array|SpaceSearchParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SpaceSearchParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/spaces/search',
            query: $parsed,
            options: $options,
            convert: SpaceSearchResponse::class,
        );
    }

    /**
     * @api
     *
     * Returns 1 X Space as X shows it, live, scheduled or ended. Accepts the Space ID or the URL-encoded Space URL. A Space X limits to subscribers or a community answers 404.
     *
     * @param array<string,mixed>|SpaceRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SpaceRetrieveResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|SpaceRetrieveParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SpaceRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/spaces/%1$s', $id],
            query: $parsed,
            options: $options,
            convert: SpaceRetrieveResponse::class,
        );
    }

    /**
     * @api
     *
     * Returns the recording X plays back once a Space is over, in state Ended or TimedOut. Accepts the Space ID or the URL-encoded Space URL. Check state and isAvailableForReplay with the Space lookup first. A live or scheduled Space answers 409, and a cancelled one 404.
     *
     * @param array<string,mixed>|SpaceRetrieveReplayParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SpaceRetrieveReplayResponse>
     *
     * @throws APIException
     */
    public function retrieveReplay(
        string $id,
        array|SpaceRetrieveReplayParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SpaceRetrieveReplayParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/spaces/%1$s/replay', $id],
            query: $parsed,
            options: $options,
            convert: SpaceRetrieveReplayResponse::class,
        );
    }
}
