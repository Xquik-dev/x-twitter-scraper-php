<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\XGetArticleResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\XGetArticleResponse\Article\Content;
use XTwitterScraper\X\XGetArticleResponse\Article\UnknownCounts;

/**
 * @phpstan-import-type ContentShape from Content
 *
 * @phpstan-type ArticleShape = array{
 *   bodyText?: string|null,
 *   contents?: list<Content|ContentShape>|null,
 *   coverImageURL?: string|null,
 *   createdAt?: string|null,
 *   likeCount?: int|null,
 *   previewText?: string|null,
 *   quoteCount?: int|null,
 *   replyCount?: int|null,
 *   title?: string|null,
 *   viewCount?: int|null,
 *   articleID?: string|null,
 *   summaryText?: string|null,
 *   coverMedia?: array<string,mixed>|null,
 *   metadata?: array<string,mixed>|null,
 *   lifecycleState?: array<string,mixed>|null,
 *   bodyMarkdown?: string|null,
 *   retweetCount?: int|null,
 *   bookmarkCount?: int|null,
 *   unknownCounts?: list<UnknownCounts|value-of<UnknownCounts>>|null,
 * }
 */
final class Article implements BaseModel
{
    /** @use SdkModel<ArticleShape> */
    use SdkModel;

    /**
     * Plain text joined from all article blocks.
     */
    #[Optional]
    public ?string $bodyText;

    /** @var list<Content>|null $contents */
    #[Optional(list: Content::class)]
    public ?array $contents;

    #[Optional('coverImageUrl')]
    public ?string $coverImageURL;

    #[Optional]
    public ?string $createdAt;

    #[Optional]
    public ?int $likeCount;

    #[Optional]
    public ?string $previewText;

    #[Optional]
    public ?int $quoteCount;

    #[Optional]
    public ?int $replyCount;

    #[Optional]
    public ?string $title;

    #[Optional]
    public ?int $viewCount;

    /**
     * X's ID for the Article, which differs from its post's ID.
     */
    #[Optional('articleId')]
    public ?string $articleID;

    /**
     * X's summary of the Article, when X has one.
     */
    #[Optional]
    public ?string $summaryText;

    /**
     * Public metadata whose fields X defines.
     *
     * @var array<string,mixed>|null $coverMedia
     */
    #[Optional(map: 'mixed')]
    public ?array $coverMedia;

    /**
     * Public metadata whose fields X defines.
     *
     * @var array<string,mixed>|null $metadata
     */
    #[Optional(map: 'mixed')]
    public ?array $metadata;

    /**
     * Public metadata whose fields X defines.
     *
     * @var array<string,mixed>|null $lifecycleState
     */
    #[Optional(map: 'mixed')]
    public ?array $lifecycleState;

    /**
     * Article blocks as Markdown, with headings, lists, bold, italic, links, images & embedded posts as their x.com URLs. Holds no HTML.
     */
    #[Optional]
    public ?string $bodyMarkdown;

    /**
     * Reposts of the Article's post. 0 or more.
     */
    #[Optional]
    public ?int $retweetCount;

    /**
     * Accounts that bookmarked the Article's post. 0 or more.
     */
    #[Optional]
    public ?int $bookmarkCount;

    /**
     * The counts X did not send for this post. Each one reads 0, so treat it as unknown rather than none. Names follow the response's key style, so `xquik-api-contract: 2026-04-29` lists bookmark_count. Posts from before X counted views, & new posts X has not counted views for yet, list viewCount. Left out when X sent every count. Counts X didn't send are listed in `unknownCounts`, never shown as 0.
     *
     * @var list<value-of<UnknownCounts>>|null $unknownCounts
     */
    #[Optional(list: UnknownCounts::class)]
    public ?array $unknownCounts;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Content|ContentShape>|null $contents
     * @param array<string,mixed>|null $coverMedia
     * @param array<string,mixed>|null $metadata
     * @param array<string,mixed>|null $lifecycleState
     * @param list<UnknownCounts|value-of<UnknownCounts>>|null $unknownCounts
     */
    public static function with(
        ?string $bodyText = null,
        ?array $contents = null,
        ?string $coverImageURL = null,
        ?string $createdAt = null,
        ?int $likeCount = null,
        ?string $previewText = null,
        ?int $quoteCount = null,
        ?int $replyCount = null,
        ?string $title = null,
        ?int $viewCount = null,
        ?string $articleID = null,
        ?string $summaryText = null,
        ?array $coverMedia = null,
        ?array $metadata = null,
        ?array $lifecycleState = null,
        ?string $bodyMarkdown = null,
        ?int $retweetCount = null,
        ?int $bookmarkCount = null,
        ?array $unknownCounts = null
    ): self {
        $self = new self;

        null !== $bodyText && $self['bodyText'] = $bodyText;
        null !== $contents && $self['contents'] = $contents;
        null !== $coverImageURL && $self['coverImageURL'] = $coverImageURL;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $likeCount && $self['likeCount'] = $likeCount;
        null !== $previewText && $self['previewText'] = $previewText;
        null !== $quoteCount && $self['quoteCount'] = $quoteCount;
        null !== $replyCount && $self['replyCount'] = $replyCount;
        null !== $title && $self['title'] = $title;
        null !== $viewCount && $self['viewCount'] = $viewCount;

        null !== $articleID && $self['articleID'] = $articleID;

        null !== $summaryText && $self['summaryText'] = $summaryText;

        null !== $coverMedia && $self['coverMedia'] = $coverMedia;

        null !== $metadata && $self['metadata'] = $metadata;

        null !== $lifecycleState && $self['lifecycleState'] = $lifecycleState;

        null !== $bodyMarkdown && $self['bodyMarkdown'] = $bodyMarkdown;

        null !== $retweetCount && $self['retweetCount'] = $retweetCount;

        null !== $bookmarkCount && $self['bookmarkCount'] = $bookmarkCount;

        null !== $unknownCounts && $self['unknownCounts'] = $unknownCounts;

        return $self;
    }

    /**
     * Plain text joined from all article blocks.
     */
    public function withBodyText(string $bodyText): self
    {
        $self = clone $this;
        $self['bodyText'] = $bodyText;

        return $self;
    }

    /**
     * @param list<Content|ContentShape> $contents
     */
    public function withContents(array $contents): self
    {
        $self = clone $this;
        $self['contents'] = $contents;

        return $self;
    }

    public function withCoverImageURL(string $coverImageURL): self
    {
        $self = clone $this;
        $self['coverImageURL'] = $coverImageURL;

        return $self;
    }

    public function withCreatedAt(string $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withLikeCount(int $likeCount): self
    {
        $self = clone $this;
        $self['likeCount'] = $likeCount;

        return $self;
    }

    public function withPreviewText(string $previewText): self
    {
        $self = clone $this;
        $self['previewText'] = $previewText;

        return $self;
    }

    public function withQuoteCount(int $quoteCount): self
    {
        $self = clone $this;
        $self['quoteCount'] = $quoteCount;

        return $self;
    }

    public function withReplyCount(int $replyCount): self
    {
        $self = clone $this;
        $self['replyCount'] = $replyCount;

        return $self;
    }

    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    public function withViewCount(int $viewCount): self
    {
        $self = clone $this;
        $self['viewCount'] = $viewCount;

        return $self;
    }

    /**
     * X's ID for the Article, which differs from its post's ID.
     */
    public function withArticleID(?string $articleID): self
    {
        $self = clone $this;
        $self['articleID'] = $articleID;

        return $self;
    }

    /**
     * X's summary of the Article, when X has one.
     */
    public function withSummaryText(?string $summaryText): self
    {
        $self = clone $this;
        $self['summaryText'] = $summaryText;

        return $self;
    }

    /**
     * Public metadata whose fields X defines.
     *
     * @param array<string,mixed>|null $coverMedia
     */
    public function withCoverMedia(?array $coverMedia): self
    {
        $self = clone $this;
        $self['coverMedia'] = $coverMedia;

        return $self;
    }

    /**
     * Public metadata whose fields X defines.
     *
     * @param array<string,mixed>|null $metadata
     */
    public function withMetadata(?array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Public metadata whose fields X defines.
     *
     * @param array<string,mixed>|null $lifecycleState
     */
    public function withLifecycleState(?array $lifecycleState): self
    {
        $self = clone $this;
        $self['lifecycleState'] = $lifecycleState;

        return $self;
    }

    /**
     * Article blocks as Markdown, with headings, lists, bold, italic, links, images & embedded posts as their x.com URLs. Holds no HTML.
     */
    public function withBodyMarkdown(?string $bodyMarkdown): self
    {
        $self = clone $this;
        $self['bodyMarkdown'] = $bodyMarkdown;

        return $self;
    }

    /**
     * Reposts of the Article's post. 0 or more.
     */
    public function withRetweetCount(?int $retweetCount): self
    {
        $self = clone $this;
        $self['retweetCount'] = $retweetCount;

        return $self;
    }

    /**
     * Accounts that bookmarked the Article's post. 0 or more.
     */
    public function withBookmarkCount(?int $bookmarkCount): self
    {
        $self = clone $this;
        $self['bookmarkCount'] = $bookmarkCount;

        return $self;
    }

    /**
     * The counts X did not send for this post. Each one reads 0, so treat it as unknown rather than none. Names follow the response's key style, so `xquik-api-contract: 2026-04-29` lists bookmark_count. Posts from before X counted views, & new posts X has not counted views for yet, list viewCount. Left out when X sent every count. Counts X didn't send are listed in `unknownCounts`, never shown as 0.
     *
     * @param list<UnknownCounts|value-of<UnknownCounts>>|null $unknownCounts
     */
    public function withUnknownCounts(?array $unknownCounts): self
    {
        $self = clone $this;
        $self['unknownCounts'] = $unknownCounts;

        return $self;
    }
}
