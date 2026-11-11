<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Media;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\ImageFilterSummary;
use XTwitterScraper\X\Media\MediaDownloadResponse\Items;

/**
 * @phpstan-import-type ImageFilterSummaryShape from ImageFilterSummary
 *
 * @phpstan-type MediaDownloadResponseShape = array{
 *   cacheHit?: bool|null,
 *   galleryURL?: string|null,
 *   imageFilter?: null|ImageFilterSummary|ImageFilterSummaryShape,
 *   totalMedia?: int|null,
 *   totalTweets?: int|null,
 *   tweetID?: string|null,
 *   items?: list<Items|array<string,mixed>>|null,
 *   unprocessedTweetIDs?: list<string>|null,
 *   failedTweetIDs?: list<string>|null,
 *   noMediaTweetIDs?: list<string>|null,
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

    /**
     * What the image filter asked & how many posts it kept. Present when you send imageShows.
     */
    #[Optional]
    public ?ImageFilterSummary $imageFilter;

    #[Optional]
    public ?int $totalMedia;

    #[Optional]
    public ?int $totalTweets;

    #[Optional('tweetId')]
    public ?string $tweetID;

    /**
     * The post's files saved to your gallery. Single downloads only. Empty when imageShows kept no photo.
     *
     * @var list<Items>|null $items
     */
    #[Optional(list: Items::class)]
    public ?array $items;

    /**
     * Posts Xquik had no time to read, at no charge. Send them again.
     *
     * @var list<string>|null $unprocessedTweetIDs
     */
    #[Optional('unprocessedTweetIds', list: 'string')]
    public ?array $unprocessedTweetIDs;

    /**
     * Posts Xquik couldn't read, at no charge. Send them again.
     *
     * @var list<string>|null $failedTweetIDs
     */
    #[Optional('failedTweetIds', list: 'string')]
    public ?array $failedTweetIDs;

    /**
     * Posts with no media to save, at no charge.
     *
     * @var list<string>|null $noMediaTweetIDs
     */
    #[Optional('noMediaTweetIds', list: 'string')]
    public ?array $noMediaTweetIDs;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param ImageFilterSummary|ImageFilterSummaryShape|null $imageFilter
     * @param list<Items|array<string,mixed>>|null $items
     * @param list<string>|null $unprocessedTweetIDs
     * @param list<string>|null $failedTweetIDs
     * @param list<string>|null $noMediaTweetIDs
     */
    public static function with(
        ?bool $cacheHit = null,
        ?string $galleryURL = null,
        ImageFilterSummary|array|null $imageFilter = null,
        ?int $totalMedia = null,
        ?int $totalTweets = null,
        ?string $tweetID = null,
        ?array $items = null,
        ?array $unprocessedTweetIDs = null,
        ?array $failedTweetIDs = null,
        ?array $noMediaTweetIDs = null,
    ): self {
        $self = new self;

        null !== $cacheHit && $self['cacheHit'] = $cacheHit;
        null !== $galleryURL && $self['galleryURL'] = $galleryURL;
        null !== $imageFilter && $self['imageFilter'] = $imageFilter;
        null !== $totalMedia && $self['totalMedia'] = $totalMedia;
        null !== $totalTweets && $self['totalTweets'] = $totalTweets;
        null !== $tweetID && $self['tweetID'] = $tweetID;

        null !== $items && $self['items'] = $items;

        null !== $unprocessedTweetIDs && $self['unprocessedTweetIDs'] = $unprocessedTweetIDs;
        null !== $failedTweetIDs && $self['failedTweetIDs'] = $failedTweetIDs;
        null !== $noMediaTweetIDs && $self['noMediaTweetIDs'] = $noMediaTweetIDs;

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

    /**
     * What the image filter asked & how many posts it kept. Present when you send imageShows.
     *
     * @param ImageFilterSummary|ImageFilterSummaryShape $imageFilter
     */
    public function withImageFilter(ImageFilterSummary|array $imageFilter): self
    {
        $self = clone $this;
        $self['imageFilter'] = $imageFilter;

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

    /**
     * The post's files saved to your gallery. Single downloads only. Empty when imageShows kept no photo.
     *
     * @param list<Items|array<string,mixed>>|null $items
     */
    public function withItems(?array $items): self
    {
        $self = clone $this;
        $self['items'] = $items;

        return $self;
    }

    /**
     * Posts Xquik had no time to read, at no charge. Send them again.
     *
     * @param list<string>|null $unprocessedTweetIDs
     */
    public function withUnprocessedTweetIDs(?array $unprocessedTweetIDs): self
    {
        $self = clone $this;
        $self['unprocessedTweetIDs'] = $unprocessedTweetIDs;

        return $self;
    }

    /**
     * Posts Xquik couldn't read, at no charge. Send them again.
     *
     * @param list<string>|null $failedTweetIDs
     */
    public function withFailedTweetIDs(?array $failedTweetIDs): self
    {
        $self = clone $this;
        $self['failedTweetIDs'] = $failedTweetIDs;

        return $self;
    }

    /**
     * Posts with no media to save, at no charge.
     *
     * @param list<string>|null $noMediaTweetIDs
     */
    public function withNoMediaTweetIDs(?array $noMediaTweetIDs): self
    {
        $self = clone $this;
        $self['noMediaTweetIDs'] = $noMediaTweetIDs;

        return $self;
    }
}
