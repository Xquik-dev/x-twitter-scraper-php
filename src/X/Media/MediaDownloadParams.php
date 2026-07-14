<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Media;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Download images and videos from tweets.
 *
 * @see XTwitterScraper\Services\X\MediaService::download()
 *
 * @phpstan-type MediaDownloadParamsShape = array{
 *   tweetID?: string|null,
 *   tweetIDs?: list<string>|null,
 *   tweetInput?: string|null,
 *   tweetURL?: string|null,
 * }
 */
final class MediaDownloadParams implements BaseModel
{
    /** @use SdkModel<MediaDownloadParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Numeric tweet ID alias for tweetInput.
     */
    #[Optional('tweetId')]
    public ?string $tweetID;

    /**
     * Array of tweet URLs or IDs (bulk, max 50 string items).
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

    /**
     * Tweet URL alias for tweetInput.
     */
    #[Optional('tweetUrl')]
    public ?string $tweetURL;

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
        ?string $tweetID = null,
        ?array $tweetIDs = null,
        ?string $tweetInput = null,
        ?string $tweetURL = null,
    ): self {
        $self = new self;

        null !== $tweetID && $self['tweetID'] = $tweetID;
        null !== $tweetIDs && $self['tweetIDs'] = $tweetIDs;
        null !== $tweetInput && $self['tweetInput'] = $tweetInput;
        null !== $tweetURL && $self['tweetURL'] = $tweetURL;

        return $self;
    }

    /**
     * Numeric tweet ID alias for tweetInput.
     */
    public function withTweetID(string $tweetID): self
    {
        $self = clone $this;
        $self['tweetID'] = $tweetID;

        return $self;
    }

    /**
     * Array of tweet URLs or IDs (bulk, max 50 string items).
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

    /**
     * Tweet URL alias for tweetInput.
     */
    public function withTweetURL(string $tweetURL): self
    {
        $self = clone $this;
        $self['tweetURL'] = $tweetURL;

        return $self;
    }
}
