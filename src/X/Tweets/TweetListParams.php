<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get multiple tweets by IDs.
 *
 * @see XTwitterScraper\Services\X\TweetsService::list()
 *
 * @phpstan-type TweetListParamsShape = array{ids: string}
 */
final class TweetListParams implements BaseModel
{
    /** @use SdkModel<TweetListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Comma-separated tweet IDs (max 100).
     */
    #[Required]
    public string $ids;

    /**
     * `new TweetListParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetListParams::with(ids: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetListParams)->withIDs(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $ids): self
    {
        $self = new self;

        $self['ids'] = $ids;

        return $self;
    }

    /**
     * Comma-separated tweet IDs (max 100).
     */
    public function withIDs(string $ids): self
    {
        $self = clone $this;
        $self['ids'] = $ids;

        return $self;
    }
}
