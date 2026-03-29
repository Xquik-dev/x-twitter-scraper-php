<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Media;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type MediaDownloadResponseShape = array{
 *   cacheHit?: bool|null,
 *   galleryURL?: string|null,
 *   totalMedia?: int|null,
 *   totalTweets?: int|null,
 *   tweetID?: string|null,
 * }
 */
final class MediaDownloadResponse implements BaseModel
{
    /** @use SdkModel<MediaDownloadResponseShape> */
    use SdkModel;

    #[Optional]
    public ?bool $cacheHit;

    #[Optional('galleryUrl')]
    public ?string $galleryURL;

    #[Optional]
    public ?int $totalMedia;

    #[Optional]
    public ?int $totalTweets;

    #[Optional('tweetId')]
    public ?string $tweetID;

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
        ?bool $cacheHit = null,
        ?string $galleryURL = null,
        ?int $totalMedia = null,
        ?int $totalTweets = null,
        ?string $tweetID = null,
    ): self {
        $self = new self;

        null !== $cacheHit && $self['cacheHit'] = $cacheHit;
        null !== $galleryURL && $self['galleryURL'] = $galleryURL;
        null !== $totalMedia && $self['totalMedia'] = $totalMedia;
        null !== $totalTweets && $self['totalTweets'] = $totalTweets;
        null !== $tweetID && $self['tweetID'] = $tweetID;

        return $self;
    }

    public function withCacheHit(bool $cacheHit): self
    {
        $self = clone $this;
        $self['cacheHit'] = $cacheHit;

        return $self;
    }

    public function withGalleryURL(string $galleryURL): self
    {
        $self = clone $this;
        $self['galleryURL'] = $galleryURL;

        return $self;
    }

    public function withTotalMedia(int $totalMedia): self
    {
        $self = clone $this;
        $self['totalMedia'] = $totalMedia;

        return $self;
    }

    public function withTotalTweets(int $totalTweets): self
    {
        $self = clone $this;
        $self['totalTweets'] = $totalTweets;

        return $self;
    }

    public function withTweetID(string $tweetID): self
    {
        $self = clone $this;
        $self['tweetID'] = $tweetID;

        return $self;
    }
}
