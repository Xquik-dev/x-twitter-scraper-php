<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Media;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Download tweet media.
 *
 * @see XTwitterScraper\Services\X\MediaService::download()
 *
 * @phpstan-type MediaDownloadParamsShape = array{
 *   tweetIDs?: list<string>|null, tweetInput?: string|null
 * }
 */
final class MediaDownloadParams implements BaseModel
{
    /** @use SdkModel<MediaDownloadParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Array of tweet URLs or IDs (bulk, max 50).
     *
     * @var list<string>|null $tweetIDs
     */
    #[Optional('tweetIds', list: 'string')]
    public ?array $tweetIDs;

    /**
     * Tweet URL or ID (single tweet).
     */
    #[Optional]
    public ?string $tweetInput;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $tweetIDs
     */
    public static function with(
        ?array $tweetIDs = null,
        ?string $tweetInput = null
    ): self {
        $self = new self;

        null !== $tweetIDs && $self['tweetIDs'] = $tweetIDs;
        null !== $tweetInput && $self['tweetInput'] = $tweetInput;

        return $self;
    }

    /**
     * Array of tweet URLs or IDs (bulk, max 50).
     *
     * @param list<string> $tweetIDs
     */
    public function withTweetIDs(array $tweetIDs): self
    {
        $self = clone $this;
        $self['tweetIDs'] = $tweetIDs;

        return $self;
    }

    /**
     * Tweet URL or ID (single tweet).
     */
    public function withTweetInput(string $tweetInput): self
    {
        $self = clone $this;
        $self['tweetInput'] = $tweetInput;

        return $self;
    }
}
