<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\PostMonitor\AuthorAffiliate;
use XTwitterScraper\PostMonitor\AuthorVerified;
use XTwitterScraper\PostMonitor\Baseline;
use XTwitterScraper\PostMonitor\Media;
use XTwitterScraper\PostMonitor\PausedReason;

/**
 * @phpstan-type PostMonitorShape = array{
 *   id: string,
 *   postID: string,
 *   postUrl: string,
 *   authorID: string,
 *   authorUsername: string,
 *   authorName: string,
 *   media: list<Media|array<string,mixed>>,
 *   text: string,
 *   postedAt: \DateTimeInterface,
 *   eventTypes: list<PostEventType|value-of<PostEventType>>,
 *   isActive: bool,
 *   createdAt: \DateTimeInterface,
 *   nextBillingAt: \DateTimeInterface,
 *   baseline: Baseline|array<string,mixed>,
 *   metrics: PostMetrics|array<string,mixed>,
 *   name?: string|null,
 *   authorAvatarUrl?: string|null,
 *   authorVerified?: AuthorVerified|value-of<AuthorVerified>|null,
 *   authorAffiliate?: AuthorAffiliate|array<string,mixed>|null,
 *   pausedReason?: PausedReason|value-of<PausedReason>|null,
 *   pausedAt?: \DateTimeInterface|null,
 * }
 */
final class PostMonitor implements BaseModel
{
    /** @use SdkModel<PostMonitorShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /**
     * ID of the post you gave.
     */
    #[Required('postId')]
    public string $postID;

    #[Required]
    public string $postUrl;

    /**
     * Permanent X user ID of the post's author.
     */
    #[Required('authorId')]
    public string $authorID;

    #[Required]
    public string $authorUsername;

    #[Required]
    public string $authorName;

    /**
     * Photos, videos & GIFs on the post, in X's order.
     *
     * @var list<Media> $media
     */
    #[Required(list: Media::class)]
    public array $media;

    /**
     * Text of the newest version Xquik read.
     */
    #[Required]
    public string $text;

    #[Required]
    public \DateTimeInterface $postedAt;

    /**
     * Post event types to send. Without it, a monitor sends new replies, new quotes, like & retweet changes, edits & deletion.
     *
     * @var list<value-of<PostEventType>> $eventTypes
     */
    #[Required(list: PostEventType::class)]
    public array $eventTypes;

    #[Required]
    public bool $isActive;

    #[Required]
    public \DateTimeInterface $createdAt;

    /**
     * Next hourly credit charge time for this post monitor.
     */
    #[Required]
    public \DateTimeInterface $nextBillingAt;

    /**
     * Counts Xquik read when tracking began. Each metric's gain counts from here. views is null when X showed no view count.
     */
    #[Required]
    public Baseline $baseline;

    /**
     * The 6 metrics of a post.
     */
    #[Required]
    public PostMetrics $metrics;

    /**
     * Customer-set label of the post monitor, when set.
     */
    #[Optional]
    public ?string $name;

    /**
     * The author's profile picture. Omitted when X shows none.
     */
    #[Optional]
    public ?string $authorAvatarUrl;

    /**
     * The author's verified badge on X. Omitted when the author has none.
     *
     * @var value-of<AuthorVerified>|null $authorVerified
     */
    #[Optional(enum: AuthorVerified::class)]
    public ?string $authorVerified;

    /**
     * The organization badge X shows beside the author's name. Omitted when X shows none.
     */
    #[Optional]
    public ?AuthorAffiliate $authorAffiliate;

    /**
     * Why Xquik paused this post monitor. insufficient_credits means the balance could not pay an hour, so add credits & resume. The other 3 mean X stopped showing the post. Absent when the monitor is active or you paused it yourself.
     *
     * @var value-of<PausedReason>|null $pausedReason
     */
    #[Optional(enum: PausedReason::class)]
    public ?string $pausedReason;

    /**
     * When Xquik paused this post monitor.
     */
    #[Optional]
    public ?\DateTimeInterface $pausedAt;

    /**
     * `new PostMonitor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PostMonitor::with(id: ..., postID: ..., postUrl: ..., authorID: ..., authorUsername: ..., authorName: ..., media: ..., text: ..., postedAt: ..., eventTypes: ..., isActive: ..., createdAt: ..., nextBillingAt: ..., baseline: ..., metrics: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PostMonitor)->withId(...)->withPostID(...)->withPostUrl(...)->withAuthorID(...)->withAuthorUsername(...)->withAuthorName(...)->withMedia(...)->withText(...)->withPostedAt(...)->withEventTypes(...)->withIsActive(...)->withCreatedAt(...)->withNextBillingAt(...)->withBaseline(...)->withMetrics(...)
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
     * @param list<Media|array<string,mixed>> $media
     * @param list<PostEventType|value-of<PostEventType>> $eventTypes
     * @param Baseline|array<string,mixed> $baseline
     * @param PostMetrics|array<string,mixed> $metrics
     * @param AuthorVerified|value-of<AuthorVerified>|null $authorVerified
     * @param AuthorAffiliate|array<string,mixed>|null $authorAffiliate
     * @param PausedReason|value-of<PausedReason>|null $pausedReason
     */
    public static function with(string $id, string $postID, string $postUrl, string $authorID, string $authorUsername, string $authorName, array $media, string $text, \DateTimeInterface $postedAt, array $eventTypes, bool $isActive, \DateTimeInterface $createdAt, \DateTimeInterface $nextBillingAt, Baseline|array $baseline, PostMetrics|array $metrics, ?string $name = null, ?string $authorAvatarUrl = null, AuthorVerified|string|null $authorVerified = null, AuthorAffiliate|array|null $authorAffiliate = null, PausedReason|string|null $pausedReason = null, ?\DateTimeInterface $pausedAt = null): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['postID'] = $postID;
        $self['postUrl'] = $postUrl;
        $self['authorID'] = $authorID;
        $self['authorUsername'] = $authorUsername;
        $self['authorName'] = $authorName;
        $self['media'] = $media;
        $self['text'] = $text;
        $self['postedAt'] = $postedAt;
        $self['eventTypes'] = $eventTypes;
        $self['isActive'] = $isActive;
        $self['createdAt'] = $createdAt;
        $self['nextBillingAt'] = $nextBillingAt;
        $self['baseline'] = $baseline;
        $self['metrics'] = $metrics;

        null !== $name && $self['name'] = $name;
        null !== $authorAvatarUrl && $self['authorAvatarUrl'] = $authorAvatarUrl;
        null !== $authorVerified && $self['authorVerified'] = $authorVerified;
        null !== $authorAffiliate && $self['authorAffiliate'] = $authorAffiliate;
        null !== $pausedReason && $self['pausedReason'] = $pausedReason;
        null !== $pausedAt && $self['pausedAt'] = $pausedAt;

        return $self;
    }

    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * ID of the post you gave.
     */
    public function withPostID(string $postID): self
    {
        $self = clone $this;
        $self['postID'] = $postID;

        return $self;
    }

    public function withPostUrl(string $postUrl): self
    {
        $self = clone $this;
        $self['postUrl'] = $postUrl;

        return $self;
    }

    /**
     * Permanent X user ID of the post's author.
     */
    public function withAuthorID(string $authorID): self
    {
        $self = clone $this;
        $self['authorID'] = $authorID;

        return $self;
    }

    public function withAuthorUsername(string $authorUsername): self
    {
        $self = clone $this;
        $self['authorUsername'] = $authorUsername;

        return $self;
    }

    public function withAuthorName(string $authorName): self
    {
        $self = clone $this;
        $self['authorName'] = $authorName;

        return $self;
    }

    /**
     * Photos, videos & GIFs on the post, in X's order.
     *
     * @param list<Media|array<string,mixed>> $media
     */
    public function withMedia(array $media): self
    {
        $self = clone $this;
        $self['media'] = $media;

        return $self;
    }

    /**
     * Text of the newest version Xquik read.
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    public function withPostedAt(\DateTimeInterface $postedAt): self
    {
        $self = clone $this;
        $self['postedAt'] = $postedAt;

        return $self;
    }

    /**
     * Post event types to send. Without it, a monitor sends new replies, new quotes, like & retweet changes, edits & deletion.
     *
     * @param list<PostEventType|value-of<PostEventType>> $eventTypes
     */
    public function withEventTypes(array $eventTypes): self
    {
        $self = clone $this;
        $self['eventTypes'] = $eventTypes;

        return $self;
    }

    public function withIsActive(bool $isActive): self
    {
        $self = clone $this;
        $self['isActive'] = $isActive;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Next hourly credit charge time for this post monitor.
     */
    public function withNextBillingAt(\DateTimeInterface $nextBillingAt): self
    {
        $self = clone $this;
        $self['nextBillingAt'] = $nextBillingAt;

        return $self;
    }

    /**
     * Counts Xquik read when tracking began. Each metric's gain counts from here. views is null when X showed no view count.
     *
     * @param Baseline|array<string,mixed> $baseline
     */
    public function withBaseline(Baseline|array $baseline): self
    {
        $self = clone $this;
        $self['baseline'] = $baseline;

        return $self;
    }

    /**
     * The 6 metrics of a post.
     *
     * @param PostMetrics|array<string,mixed> $metrics
     */
    public function withMetrics(PostMetrics|array $metrics): self
    {
        $self = clone $this;
        $self['metrics'] = $metrics;

        return $self;
    }

    /**
     * Customer-set label of the post monitor, when set.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * The author's profile picture. Omitted when X shows none.
     */
    public function withAuthorAvatarUrl(?string $authorAvatarUrl): self
    {
        $self = clone $this;
        $self['authorAvatarUrl'] = $authorAvatarUrl;

        return $self;
    }

    /**
     * The author's verified badge on X. Omitted when the author has none.
     *
     * @param AuthorVerified|value-of<AuthorVerified>|null $authorVerified
     */
    public function withAuthorVerified(AuthorVerified|string|null $authorVerified): self
    {
        $self = clone $this;
        $self['authorVerified'] = $authorVerified;

        return $self;
    }

    /**
     * The organization badge X shows beside the author's name. Omitted when X shows none.
     *
     * @param AuthorAffiliate|array<string,mixed>|null $authorAffiliate
     */
    public function withAuthorAffiliate(AuthorAffiliate|array|null $authorAffiliate): self
    {
        $self = clone $this;
        $self['authorAffiliate'] = $authorAffiliate;

        return $self;
    }

    /**
     * Why Xquik paused this post monitor. insufficient_credits means the balance could not pay an hour, so add credits & resume. The other 3 mean X stopped showing the post. Absent when the monitor is active or you paused it yourself.
     *
     * @param PausedReason|value-of<PausedReason>|null $pausedReason
     */
    public function withPausedReason(PausedReason|string|null $pausedReason): self
    {
        $self = clone $this;
        $self['pausedReason'] = $pausedReason;

        return $self;
    }

    /**
     * When Xquik paused this post monitor.
     */
    public function withPausedAt(?\DateTimeInterface $pausedAt): self
    {
        $self = clone $this;
        $self['pausedAt'] = $pausedAt;

        return $self;
    }
}
