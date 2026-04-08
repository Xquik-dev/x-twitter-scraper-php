<?php

declare(strict_types=1);

namespace XTwitterScraper\X;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\XGetArticleResponse\Article;
use XTwitterScraper\X\XGetArticleResponse\Author;

/**
 * @phpstan-import-type ArticleShape from \XTwitterScraper\X\XGetArticleResponse\Article
 * @phpstan-import-type AuthorShape from \XTwitterScraper\X\XGetArticleResponse\Author
 *
 * @phpstan-type XGetArticleResponseShape = array{
 *   article: Article|ArticleShape, author?: null|Author|AuthorShape
 * }
 */
final class XGetArticleResponse implements BaseModel
{
    /** @use SdkModel<XGetArticleResponseShape> */
    use SdkModel;

    #[Required]
    public Article $article;

    /**
     * Author of a tweet with follower count and verification status.
     */
    #[Optional]
    public ?Author $author;

    /**
     * `new XGetArticleResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XGetArticleResponse::with(article: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XGetArticleResponse)->withArticle(...)
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
     * @param Article|ArticleShape $article
     * @param Author|AuthorShape|null $author
     */
    public static function with(
        Article|array $article,
        Author|array|null $author = null
    ): self {
        $self = new self;

        $self['article'] = $article;

        null !== $author && $self['author'] = $author;

        return $self;
    }

    /**
     * @param Article|ArticleShape $article
     */
    public function withArticle(Article|array $article): self
    {
        $self = clone $this;
        $self['article'] = $article;

        return $self;
    }

    /**
     * Author of a tweet with follower count and verification status.
     *
     * @param Author|AuthorShape $author
     */
    public function withAuthor(Author|array $author): self
    {
        $self = clone $this;
        $self['author'] = $author;

        return $self;
    }
}
