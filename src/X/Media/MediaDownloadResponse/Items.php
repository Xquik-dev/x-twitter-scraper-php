<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Media\MediaDownloadResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Media\MediaDownloadResponse\Items\MediaType;
use XTwitterScraper\X\Media\MediaDownloadResponse\Items\Qualities;

/**
 * @phpstan-type ItemsShape = array{
 *   id: string,
 *   tweetID: string,
 *   mediaType: MediaType|value-of<MediaType>,
 *   mediaUrl: string,
 *   posterUrl: string|null,
 *   qualities: list<Qualities|array<string,mixed>>,
 *   fileSize: string|null,
 *   createdAt: \DateTimeInterface,
 *   authorUsername: string,
 *   authorDisplayName: string,
 *   authorAvatar: string|null,
 *   tweetText: string,
 *   likes: int|null,
 *   retweets: int|null,
 *   views: int|null,
 * }
 */
final class Items implements BaseModel
{
    /** @use SdkModel<ItemsShape> */
    use SdkModel;

    /**
     * Gallery file ID.
     */
    #[Required]
    public string $id;

    #[Required('tweetId')]
    public string $tweetID;

    /**
     * @var value-of<MediaType> $mediaType
     */
    #[Required(enum: MediaType::class)]
    public string $mediaType;

    /**
     * Link to the file. It goes to X when X flagged the post or its media at save time, or sent no post flag. Xquik keeps no copy of those files.
     */
    #[Required]
    public string $mediaUrl;

    /**
     * Cover image of a video or GIF. Null for photos & files first saved to Xquik before 2026-11-03.
     */
    #[Required]
    public ?string $posterUrl;

    /**
     * The MP4 sizes X stores for a video, highest bitrate first. Empty for photos, GIFs & files first saved to Xquik before 2026-11-03.
     *
     * @var list<Qualities> $qualities
     */
    #[Required(list: Qualities::class)]
    public array $qualities;

    /**
     * File size in bytes, as a string.
     */
    #[Required]
    public ?string $fileSize;

    /**
     * When the file joined your gallery.
     */
    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public string $authorUsername;

    #[Required]
    public string $authorDisplayName;

    #[Required]
    public ?string $authorAvatar;

    #[Required]
    public string $tweetText;

    #[Required]
    public ?int $likes;

    #[Required]
    public ?int $retweets;

    #[Required]
    public ?int $views;

    /**
     * `new Items()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Items::with(id: ..., tweetID: ..., mediaType: ..., mediaUrl: ..., posterUrl: ..., qualities: ..., fileSize: ..., createdAt: ..., authorUsername: ..., authorDisplayName: ..., authorAvatar: ..., tweetText: ..., likes: ..., retweets: ..., views: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Items)->withId(...)->withTweetID(...)->withMediaType(...)->withMediaUrl(...)->withPosterUrl(...)->withQualities(...)->withFileSize(...)->withCreatedAt(...)->withAuthorUsername(...)->withAuthorDisplayName(...)->withAuthorAvatar(...)->withTweetText(...)->withLikes(...)->withRetweets(...)->withViews(...)
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
     *
     * @param MediaType|value-of<MediaType> $mediaType
     * @param list<Qualities|array<string,mixed>> $qualities
     */
    public static function with(string $id, string $tweetID, MediaType|string $mediaType, string $mediaUrl, ?string $posterUrl, array $qualities, ?string $fileSize, \DateTimeInterface $createdAt, string $authorUsername, string $authorDisplayName, ?string $authorAvatar, string $tweetText, ?int $likes, ?int $retweets, ?int $views): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['tweetID'] = $tweetID;
        $self['mediaType'] = $mediaType;
        $self['mediaUrl'] = $mediaUrl;
        $self['posterUrl'] = $posterUrl;
        $self['qualities'] = $qualities;
        $self['fileSize'] = $fileSize;
        $self['createdAt'] = $createdAt;
        $self['authorUsername'] = $authorUsername;
        $self['authorDisplayName'] = $authorDisplayName;
        $self['authorAvatar'] = $authorAvatar;
        $self['tweetText'] = $tweetText;
        $self['likes'] = $likes;
        $self['retweets'] = $retweets;
        $self['views'] = $views;

        return $self;
    }

    /**
     * Gallery file ID.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withTweetID(string $tweetID): self
    {
        $self = clone $this;
        $self['tweetID'] = $tweetID;

        return $self;
    }

    /**
     * @param MediaType|value-of<MediaType> $mediaType
     */
    public function withMediaType(MediaType|string $mediaType): self
    {
        $self = clone $this;
        $self['mediaType'] = $mediaType;

        return $self;
    }

    /**
     * Link to the file. It goes to X when X flagged the post or its media at save time, or sent no post flag. Xquik keeps no copy of those files.
     */
    public function withMediaUrl(string $mediaUrl): self
    {
        $self = clone $this;
        $self['mediaUrl'] = $mediaUrl;

        return $self;
    }

    /**
     * Cover image of a video or GIF. Null for photos & files first saved to Xquik before 2026-11-03.
     */
    public function withPosterUrl(?string $posterUrl): self
    {
        $self = clone $this;
        $self['posterUrl'] = $posterUrl;

        return $self;
    }

    /**
     * The MP4 sizes X stores for a video, highest bitrate first. Empty for photos, GIFs & files first saved to Xquik before 2026-11-03.
     *
     * @param list<Qualities|array<string,mixed>> $qualities
     */
    public function withQualities(array $qualities): self
    {
        $self = clone $this;
        $self['qualities'] = $qualities;

        return $self;
    }

    /**
     * File size in bytes, as a string.
     */
    public function withFileSize(?string $fileSize): self
    {
        $self = clone $this;
        $self['fileSize'] = $fileSize;

        return $self;
    }

    /**
     * When the file joined your gallery.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withAuthorUsername(string $authorUsername): self
    {
        $self = clone $this;
        $self['authorUsername'] = $authorUsername;

        return $self;
    }

    public function withAuthorDisplayName(string $authorDisplayName): self
    {
        $self = clone $this;
        $self['authorDisplayName'] = $authorDisplayName;

        return $self;
    }

    public function withAuthorAvatar(?string $authorAvatar): self
    {
        $self = clone $this;
        $self['authorAvatar'] = $authorAvatar;

        return $self;
    }

    public function withTweetText(string $tweetText): self
    {
        $self = clone $this;
        $self['tweetText'] = $tweetText;

        return $self;
    }

    public function withLikes(?int $likes): self
    {
        $self = clone $this;
        $self['likes'] = $likes;

        return $self;
    }

    public function withRetweets(?int $retweets): self
    {
        $self = clone $this;
        $self['retweets'] = $retweets;

        return $self;
    }

    public function withViews(?int $views): self
    {
        $self = clone $this;
        $self['views'] = $views;

        return $self;
    }
}
