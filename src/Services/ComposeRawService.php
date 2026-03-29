<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Compose\ComposeCreateParams;
use XTwitterScraper\Compose\ComposeCreateParams\Goal;
use XTwitterScraper\Compose\ComposeCreateParams\MediaType;
use XTwitterScraper\Compose\ComposeCreateParams\Step;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Conversion\MapOf;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\ComposeRawContract;

/**
 * Tweet composition, drafts, writing styles & radar.
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
     * Compose, refine, or score a tweet
     *
     * @param array{
     *   step: Step|value-of<Step>,
     *   additionalContext?: string,
     *   callToAction?: string,
     *   draft?: string,
     *   goal?: Goal|value-of<Goal>,
     *   hasLink?: bool,
     *   hasMedia?: bool,
     *   mediaType?: MediaType|value-of<MediaType>,
     *   styleUsername?: string,
     *   tone?: string,
     *   topic?: string,
     * }|ComposeCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<array<string,mixed>>
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
            convert: new MapOf('mixed'),
        );
    }
}
