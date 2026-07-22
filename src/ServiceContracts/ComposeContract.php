<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Compose\ComposeCreateParams\Goal;
use XTwitterScraper\Compose\ComposeCreateParams\MediaType;
use XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult;
use XTwitterScraper\Compose\ComposeNewResponse\ComposeRefineResult;
use XTwitterScraper\Compose\ComposeNewResponse\ComposeScoreResult;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface ComposeContract
{
    /**
     * @api
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
    ): ComposePrepareResult|ComposeRefineResult|ComposeScoreResult;
}
