<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Compose\ComposeCreateParams\Goal;
use XTwitterScraper\Compose\ComposeCreateParams\MediaType;
use XTwitterScraper\Compose\ComposeCreateParams\Step;
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
     * @param Step|value-of<Step> $step Workflow step
     * @param string $additionalContext Extra context or URLs (refine)
     * @param string $callToAction Desired call to action (refine)
     * @param string $draft Tweet draft text to evaluate (score)
     * @param Goal|value-of<Goal> $goal Optimization goal
     * @param bool $hasLink Whether a link is attached (score)
     * @param bool $hasMedia Whether media is attached (score)
     * @param MediaType|value-of<MediaType> $mediaType Media type (refine)
     * @param string $styleUsername Cached style username for voice matching (compose)
     * @param string $tone Desired tone (refine)
     * @param string $topic Tweet topic (compose, refine)
     * @param RequestOpts|null $requestOptions
     *
     * @return array<string,mixed>
     *
     * @throws APIException
     */
    public function create(
        Step|string $step,
        ?string $additionalContext = null,
        ?string $callToAction = null,
        ?string $draft = null,
        Goal|string|null $goal = null,
        ?bool $hasLink = null,
        ?bool $hasMedia = null,
        MediaType|string|null $mediaType = null,
        ?string $styleUsername = null,
        ?string $tone = null,
        ?string $topic = null,
        RequestOptions|array|null $requestOptions = null,
    ): array;
}
