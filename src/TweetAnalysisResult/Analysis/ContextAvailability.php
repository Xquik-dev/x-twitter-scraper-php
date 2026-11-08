<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetAnalysisResult\Analysis;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\TweetAnalysisResult\Analysis\ContextAvailability\Article;
use XTwitterScraper\TweetAnalysisResult\Analysis\ContextAvailability\Author;
use XTwitterScraper\TweetAnalysisResult\Analysis\ContextAvailability\Media;
use XTwitterScraper\TweetAnalysisResult\Analysis\ContextAvailability\PostText;
use XTwitterScraper\TweetAnalysisResult\Analysis\ContextAvailability\Quote;
use XTwitterScraper\TweetAnalysisResult\Analysis\ContextAvailability\Reply;

/**
 * @phpstan-type ContextAvailabilityShape = array{
 *   quote: Quote|value-of<Quote>,
 *   reply: Reply|value-of<Reply>,
 *   author: Author|value-of<Author>,
 *   media: Media|value-of<Media>,
 *   article: Article|value-of<Article>,
 *   postText: PostText|value-of<PostText>,
 * }
 */
final class ContextAvailability implements BaseModel
{
    /** @use SdkModel<ContextAvailabilityShape> */
    use SdkModel;

    /**
     * @var value-of<Quote> $quote
     */
    #[Required(enum: Quote::class)]
    public string $quote;

    /**
     * @var value-of<Reply> $reply
     */
    #[Required(enum: Reply::class)]
    public string $reply;

    /**
     * @var value-of<Author> $author
     */
    #[Required(enum: Author::class)]
    public string $author;

    /**
     * images when the AI read the post's images. text_descriptions_only when it read only their alt text.
     *
     * @var value-of<Media> $media
     */
    #[Required(enum: Media::class)]
    public string $media;

    /**
     * @var value-of<Article> $article
     */
    #[Required(enum: Article::class)]
    public string $article;

    /**
     * truncated when the post was cut to fit.
     *
     * @var value-of<PostText> $postText
     */
    #[Required(enum: PostText::class)]
    public string $postText;

    /**
     * `new ContextAvailability()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ContextAvailability::with(quote: ..., reply: ..., author: ..., media: ..., article: ..., postText: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ContextAvailability)->withQuote(...)->withReply(...)->withAuthor(...)->withMedia(...)->withArticle(...)->withPostText(...)
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
     * @param Quote|value-of<Quote> $quote
     * @param Reply|value-of<Reply> $reply
     * @param Author|value-of<Author> $author
     * @param Media|value-of<Media> $media
     * @param Article|value-of<Article> $article
     * @param PostText|value-of<PostText> $postText
     */
    public static function with(Quote|string $quote, Reply|string $reply, Author|string $author, Media|string $media, Article|string $article, PostText|string $postText): self
    {
        $self = new self;

        $self['quote'] = $quote;
        $self['reply'] = $reply;
        $self['author'] = $author;
        $self['media'] = $media;
        $self['article'] = $article;
        $self['postText'] = $postText;

        return $self;
    }

    /**
     * @param Quote|value-of<Quote> $quote
     */
    public function withQuote(Quote|string $quote): self
    {
        $self = clone $this;
        $self['quote'] = $quote;

        return $self;
    }

    /**
     * @param Reply|value-of<Reply> $reply
     */
    public function withReply(Reply|string $reply): self
    {
        $self = clone $this;
        $self['reply'] = $reply;

        return $self;
    }

    /**
     * @param Author|value-of<Author> $author
     */
    public function withAuthor(Author|string $author): self
    {
        $self = clone $this;
        $self['author'] = $author;

        return $self;
    }

    /**
     * images when the AI read the post's images. text_descriptions_only when it read only their alt text.
     *
     * @param Media|value-of<Media> $media
     */
    public function withMedia(Media|string $media): self
    {
        $self = clone $this;
        $self['media'] = $media;

        return $self;
    }

    /**
     * @param Article|value-of<Article> $article
     */
    public function withArticle(Article|string $article): self
    {
        $self = clone $this;
        $self['article'] = $article;

        return $self;
    }

    /**
     * truncated when the post was cut to fit.
     *
     * @param PostText|value-of<PostText> $postText
     */
    public function withPostText(PostText|string $postText): self
    {
        $self = clone $this;
        $self['postText'] = $postText;

        return $self;
    }
}
