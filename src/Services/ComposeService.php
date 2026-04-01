<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Compose\ComposeCreateParams\Goal;
use XTwitterScraper\Compose\ComposeCreateParams\MediaType;
use XTwitterScraper\Compose\ComposeCreateParams\Step;
use XTwitterScraper\Compose\ComposeNewResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\ComposeContract;

/**
 * Tweet composition, drafts, writing styles & radar.
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
     * Compose, refine, or score a tweet
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
    ): ComposeNewResponse {
        $params = Util::removeNulls(
            [
                'step' => $step,
                'additionalContext' => $additionalContext,
                'callToAction' => $callToAction,
                'draft' => $draft,
                'goal' => $goal,
                'hasLink' => $hasLink,
                'hasMedia' => $hasMedia,
                'mediaType' => $mediaType,
                'styleUsername' => $styleUsername,
                'tone' => $tone,
                'topic' => $topic,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
