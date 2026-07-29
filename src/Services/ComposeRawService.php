<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Compose\ComposeCreateParams;
use XTwitterScraper\Compose\ComposeCreateParams\Goal;
use XTwitterScraper\Compose\ComposeCreateParams\MediaType;
use XTwitterScraper\Compose\ComposeNewResponse;
use XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult;
use XTwitterScraper\Compose\ComposeNewResponse\ComposeRefineResult;
use XTwitterScraper\Compose\ComposeNewResponse\ComposeScoreResult;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\ComposeRawContract;

/**
 * AI tweet composition, drafts, writing styles, and radar.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class ComposeRawService implements ComposeRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Run one step of Xquik's three-step writing workflow. Compose returns questions, editorial rules, and source-specific Radar recommendations. Refine returns goal-specific guidance. Score applies deterministic text checks. It does not predict reach or expose X ranking weights.
     *
     * @param array{
     *   step?: 'score',
     *   topic: string,
     *   goal: Goal|value-of<Goal>,
     *   styleUsername?: string,
     *   tone: string,
     *   additionalContext?: string,
     *   callToAction?: string,
     *   mediaType?: MediaType|value-of<MediaType>,
     *   draft: string,
     *   hasLink?: bool,
     *   hasMedia?: bool,
     * }|ComposeCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ComposePrepareResult|ComposeRefineResult|ComposeScoreResult,>
     *
     * @throws APIException
     */
    public function create(
        array|ComposeCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ComposeCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'compose',
            body: (object) $parsed,
            options: $options,
            convert: ComposeNewResponse::class,
        );
    }
}
