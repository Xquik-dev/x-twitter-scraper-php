<?php

declare(strict_types=1);

namespace XTwitterScraper\X\XGetArticleResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\XGetArticleResponse\Article\Content;

/**
 * @phpstan-import-type ContentShape from \XTwitterScraper\X\XGetArticleResponse\Article\Content
 *
 * @phpstan-type ArticleShape = array{
 *   contents?: list<Content|ContentShape>|null,
 *   coverImageURL?: string|null,
 *   createdAt?: string|null,
 *   likeCount?: int|null,
 *   previewText?: string|null,
 *   quoteCount?: int|null,
 *   replyCount?: int|null,
 *   title?: string|null,
 *   viewCount?: int|null,
 * }
 */
final class Article implements BaseModel
{
    /** @use SdkModel<ArticleShape> */
    use SdkModel;

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
     */
    public static function with(
        ?array $contents = null,
        ?string $coverImageURL = null,
        ?string $createdAt = null,
        ?int $likeCount = null,
        ?string $previewText = null,
        ?int $quoteCount = null,
        ?int $replyCount = null,
        ?string $title = null,
        ?int $viewCount = null,
    ): self {
        $self = new self;

        null !== $contents && $self['contents'] = $contents;
        null !== $coverImageURL && $self['coverImageURL'] = $coverImageURL;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $likeCount && $self['likeCount'] = $likeCount;
        null !== $previewText && $self['previewText'] = $previewText;
        null !== $quoteCount && $self['quoteCount'] = $quoteCount;
        null !== $replyCount && $self['replyCount'] = $replyCount;
        null !== $title && $self['title'] = $title;
        null !== $viewCount && $self['viewCount'] = $viewCount;

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
}
