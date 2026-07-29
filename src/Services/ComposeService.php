<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Compose\ComposeCreateParams\Goal;
use XTwitterScraper\Compose\ComposeCreateParams\MediaType;
use XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult;
use XTwitterScraper\Compose\ComposeNewResponse\ComposeRefineResult;
use XTwitterScraper\Compose\ComposeNewResponse\ComposeScoreResult;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\ComposeContract;

/**
 * AI tweet composition, drafts, writing styles, and radar.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class ComposeService implements ComposeContract
{
    /**
     * @api
     */
    public ComposeRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ComposeRawService($client);
    }

    /**
     * @api
     *
     * Run one step of Xquik's three-step writing workflow. Compose returns questions, editorial rules, and source-specific Radar recommendations. Refine returns goal-specific guidance. Score applies deterministic text checks. It does not predict reach or expose X ranking weights.
     *
     * @param string $topic subject for the post
     * @param Goal|value-of<Goal> $goal editorial goal for the guidance
     * @param string $tone requested writing tone
     * @param string $draft full post text for deterministic editorial checks
     * @param 'score' $step
     * @param string $styleUsername username from a style analysis saved to this account
     * @param string $additionalContext audience, constraints, sources, or other writing context
     * @param string $callToAction specific action the draft should request
     * @param MediaType|value-of<MediaType> $mediaType planned media type
     * @param bool $hasLink true when a separate link card is attached
     * @param bool $hasMedia Accepted for backward compatibility. Text checks ignore this field.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $topic,
        Goal|string $goal,
        string $tone,
        string $draft,
        string $step = 'score',
        ?string $styleUsername = null,
        ?string $additionalContext = null,
        ?string $callToAction = null,
        MediaType|string|null $mediaType = null,
        bool $hasLink = false,
        ?bool $hasMedia = null,
        RequestOptions|array|null $requestOptions = null,
    ): ComposePrepareResult|ComposeRefineResult|ComposeScoreResult {
        $params = Util::removeNulls(
            [
                'step' => $step,
                'topic' => $topic,
                'goal' => $goal,
                'styleUsername' => $styleUsername,
                'tone' => $tone,
                'additionalContext' => $additionalContext,
                'callToAction' => $callToAction,
                'mediaType' => $mediaType,
                'draft' => $draft,
                'hasLink' => $hasLink,
                'hasMedia' => $hasMedia,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
