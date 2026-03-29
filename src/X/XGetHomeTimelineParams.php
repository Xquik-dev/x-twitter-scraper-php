<?php

declare(strict_types=1);

namespace XTwitterScraper\X;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get home timeline.
 *
 * @see XTwitterScraper\Services\XService::getHomeTimeline()
 *
 * @phpstan-type XGetHomeTimelineParamsShape = array{
 *   cursor?: string|null, seenTweetIDs?: string|null
 * }
 */
final class XGetHomeTimelineParams implements BaseModel
{
    /** @use SdkModel<XGetHomeTimelineParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Pagination cursor from previous response.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Comma-separated tweet IDs to exclude from results.
     */
    #[Optional]
    public ?string $seenTweetIDs;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?string $cursor = null,
        ?string $seenTweetIDs = null
    ): self {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $seenTweetIDs && $self['seenTweetIDs'] = $seenTweetIDs;

        return $self;
    }

    /**
     * Pagination cursor from previous response.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Comma-separated tweet IDs to exclude from results.
     */
    public function withSeenTweetIDs(string $seenTweetIDs): self
    {
        $self = clone $this;
        $self['seenTweetIDs'] = $seenTweetIDs;

        return $self;
    }
}
