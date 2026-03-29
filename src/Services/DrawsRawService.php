<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Draws\DrawExportParams;
use XTwitterScraper\Draws\DrawExportParams\Format;
use XTwitterScraper\Draws\DrawExportParams\Type;
use XTwitterScraper\Draws\DrawGetResponse;
use XTwitterScraper\Draws\DrawListParams;
use XTwitterScraper\Draws\DrawListResponse;
use XTwitterScraper\Draws\DrawRunParams;
use XTwitterScraper\Draws\DrawRunResponse;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\DrawsRawContract;

/**
 * Giveaway draws from tweet replies.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class DrawsRawService implements DrawsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get draw details
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DrawGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['draws/%1$s', $id],
            options: $requestOptions,
            convert: DrawGetResponse::class,
        );
    }

    /**
     * @api
     *
     * List draws
     *
     * @param array{after?: string, limit?: int}|DrawListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DrawListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|DrawListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DrawListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'draws',
            query: $parsed,
            options: $options,
            convert: DrawListResponse::class,
        );
    }

    /**
     * @api
     *
     * Export draw data
     *
     * @param string $id Resource ID (stringified bigint)
     * @param array{
     *   format?: Format|value-of<Format>, type?: Type|value-of<Type>
     * }|DrawExportParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<string>
     *
     * @throws APIException
     */
    public function export(
        string $id,
        array|DrawExportParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DrawExportParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['draws/%1$s/export', $id],
            query: $parsed,
            headers: ['Accept' => 'application/octet-stream'],
            options: $options,
            convert: 'string',
        );
    }

    /**
     * @api
     *
     * Run giveaway draw
     *
     * @param array{
     *   tweetURL: string,
     *   backupCount?: int,
     *   filterAccountAgeDays?: int,
     *   filterLanguage?: string,
     *   filterMinFollowers?: int,
     *   mustFollowUsername?: string,
     *   mustRetweet?: bool,
     *   requiredHashtags?: list<string>,
     *   requiredKeywords?: list<string>,
     *   requiredMentions?: list<string>,
     *   uniqueAuthorsOnly?: bool,
     *   winnerCount?: int,
     * }|DrawRunParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DrawRunResponse>
     *
     * @throws APIException
     */
    public function run(
        array|DrawRunParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DrawRunParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'draws',
            body: (object) $parsed,
            options: $options,
            convert: DrawRunResponse::class,
        );
    }
}
