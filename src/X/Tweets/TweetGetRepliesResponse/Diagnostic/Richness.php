<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetGetRepliesResponse\Diagnostic;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Field-presence counts across the collected direct replies.
 *
 * @phpstan-type RichnessShape = array{
 *   article: int,
 *   author: int,
 *   card: int,
 *   communityNote: int,
 *   createdAt: int,
 *   engagementCounts: int,
 *   entities: int,
 *   language: int,
 *   media: int,
 *   quotedOrRepostedTweet: int,
 *   text: int,
 *   totalReplies: int,
 *   url: int,
 * }
 */
final class Richness implements BaseModel
{
    /** @use SdkModel<RichnessShape> */
    use SdkModel;

    /**
     * Replies with article content.
     */
    #[Required]
    public int $article;

    /**
     * Replies with author details.
     */
    #[Required]
    public int $author;

    /**
     * Replies with card metadata.
     */
    #[Required]
    public int $card;

    /**
     * Replies with community-note data.
     */
    #[Required]
    public int $communityNote;

    /**
     * Replies with a creation timestamp.
     */
    #[Required]
    public int $createdAt;

    /**
     * Replies with engagement counts.
     */
    #[Required]
    public int $engagementCounts;

    /**
     * Replies with entity metadata.
     */
    #[Required]
    public int $entities;

    /**
     * Replies with a language value.
     */
    #[Required]
    public int $language;

    /**
     * Replies with media metadata.
     */
    #[Required]
    public int $media;

    /**
     * Replies with quoted or reposted tweet data.
     */
    #[Required]
    public int $quotedOrRepostedTweet;

    /**
     * Replies with text.
     */
    #[Required]
    public int $text;

    /**
     * Total unique direct replies evaluated for richness.
     */
    #[Required]
    public int $totalReplies;

    /**
     * Replies with a canonical URL.
     */
    #[Required]
    public int $url;

    /**
     * `new Richness()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Richness::with(
     *   article: ...,
     *   author: ...,
     *   card: ...,
     *   communityNote: ...,
     *   createdAt: ...,
     *   engagementCounts: ...,
     *   entities: ...,
     *   language: ...,
     *   media: ...,
     *   quotedOrRepostedTweet: ...,
     *   text: ...,
     *   totalReplies: ...,
     *   url: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Richness)
     *   ->withArticle(...)
     *   ->withAuthor(...)
     *   ->withCard(...)
     *   ->withCommunityNote(...)
     *   ->withCreatedAt(...)
     *   ->withEngagementCounts(...)
     *   ->withEntities(...)
     *   ->withLanguage(...)
     *   ->withMedia(...)
     *   ->withQuotedOrRepostedTweet(...)
     *   ->withText(...)
     *   ->withTotalReplies(...)
     *   ->withURL(...)
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
     */
    public static function with(
        int $article,
        int $author,
        int $card,
        int $communityNote,
        int $createdAt,
        int $engagementCounts,
        int $entities,
        int $language,
        int $media,
        int $quotedOrRepostedTweet,
        int $text,
        int $totalReplies,
        int $url,
    ): self {
        $self = new self;

        $self['article'] = $article;
        $self['author'] = $author;
        $self['card'] = $card;
        $self['communityNote'] = $communityNote;
        $self['createdAt'] = $createdAt;
        $self['engagementCounts'] = $engagementCounts;
        $self['entities'] = $entities;
        $self['language'] = $language;
        $self['media'] = $media;
        $self['quotedOrRepostedTweet'] = $quotedOrRepostedTweet;
        $self['text'] = $text;
        $self['totalReplies'] = $totalReplies;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Replies with article content.
     */
    public function withArticle(int $article): self
    {
        $self = clone $this;
        $self['article'] = $article;

        return $self;
    }

    /**
     * Replies with author details.
     */
    public function withAuthor(int $author): self
    {
        $self = clone $this;
        $self['author'] = $author;

        return $self;
    }

    /**
     * Replies with card metadata.
     */
    public function withCard(int $card): self
    {
        $self = clone $this;
        $self['card'] = $card;

        return $self;
    }

    /**
     * Replies with community-note data.
     */
    public function withCommunityNote(int $communityNote): self
    {
        $self = clone $this;
        $self['communityNote'] = $communityNote;

        return $self;
    }

    /**
     * Replies with a creation timestamp.
     */
    public function withCreatedAt(int $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Replies with engagement counts.
     */
    public function withEngagementCounts(int $engagementCounts): self
    {
        $self = clone $this;
        $self['engagementCounts'] = $engagementCounts;

        return $self;
    }

    /**
     * Replies with entity metadata.
     */
    public function withEntities(int $entities): self
    {
        $self = clone $this;
        $self['entities'] = $entities;

        return $self;
    }

    /**
     * Replies with a language value.
     */
    public function withLanguage(int $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * Replies with media metadata.
     */
    public function withMedia(int $media): self
    {
        $self = clone $this;
        $self['media'] = $media;

        return $self;
    }

    /**
     * Replies with quoted or reposted tweet data.
     */
    public function withQuotedOrRepostedTweet(int $quotedOrRepostedTweet): self
    {
        $self = clone $this;
        $self['quotedOrRepostedTweet'] = $quotedOrRepostedTweet;

        return $self;
    }

    /**
     * Replies with text.
     */
    public function withText(int $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * Total unique direct replies evaluated for richness.
     */
    public function withTotalReplies(int $totalReplies): self
    {
        $self = clone $this;
        $self['totalReplies'] = $totalReplies;

        return $self;
    }

    /**
     * Replies with a canonical URL.
     */
    public function withURL(int $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
