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

/**
 * No-mode search, user Tweet, user reply, and direct reply reads use automatic coverage. Shape, filters, aliases, and billing stay compatible. Unprefixed cursors remain legacy. Follow next_cursor while has_next_page is true. An empty filtered page can still have has_next_page true.
 *
 * @phpstan-import-type ImageFilterSummaryShape from \XTwitterScraper\ImageFilterSummary
 * @phpstan-import-type TopicFilterSummaryShape from \XTwitterScraper\TopicFilterSummary
 *
 * @phpstan-type PaginatedTweetsShape = array{
 *   hasNextPage: bool,
 *   nextCursor: string,
 *   tweets: list<mixed>,
 *   imageFilter?: null|ImageFilterSummary|ImageFilterSummaryShape,
 *   topicFilter?: null|TopicFilterSummary|TopicFilterSummaryShape,
 * }
 */
final class PaginatedTweets implements BaseModel
{
    /** @use SdkModel<PaginatedTweetsShape> */
    use SdkModel;

    #[Required('has_next_page')]
    public bool $hasNextPage;

    #[Required('next_cursor')]
    public string $nextCursor;

    /** @var list<mixed> $tweets */
    #[Required(list: SearchTweet::class)]
    public array $tweets;

    /**
     * What the image filter asked & how many posts it kept. Present when you send imageShows.
     */
    #[Optional]
    public ?ImageFilterSummary $imageFilter;

    /**
     * What the topic filter asked & how many posts it kept. Present when you send topic.
     */
    #[Optional]
    public ?TopicFilterSummary $topicFilter;

    /**
     * `new PaginatedTweets()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PaginatedTweets::with(hasNextPage: ..., nextCursor: ..., tweets: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PaginatedTweets)
     *   ->withHasNextPage(...)
     *   ->withNextCursor(...)
     *   ->withTweets(...)
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
     * @param list<mixed> $tweets
     * @param ImageFilterSummary|ImageFilterSummaryShape|null $imageFilter
     * @param TopicFilterSummary|TopicFilterSummaryShape|null $topicFilter
     */
    public static function with(
        bool $hasNextPage,
        string $nextCursor,
        array $tweets,
        ImageFilterSummary|array|null $imageFilter = null,
        TopicFilterSummary|array|null $topicFilter = null,
    ): self {
        $self = new self;

        $self['hasNextPage'] = $hasNextPage;
        $self['nextCursor'] = $nextCursor;
        $self['tweets'] = $tweets;

        null !== $imageFilter && $self['imageFilter'] = $imageFilter;
        null !== $topicFilter && $self['topicFilter'] = $topicFilter;

        return $self;
    }

    public function withHasNextPage(bool $hasNextPage): self
    {
        $self = clone $this;
        $self['hasNextPage'] = $hasNextPage;

        return $self;
    }

    public function withNextCursor(string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * @param list<mixed> $tweets
     */
    public function withTweets(array $tweets): self
    {
        $self = clone $this;
        $self['tweets'] = $tweets;

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

    /**
     * What the topic filter asked & how many posts it kept. Present when you send topic.
     *
     * @param TopicFilterSummary|TopicFilterSummaryShape $topicFilter
     */
    public function withTopicFilter(TopicFilterSummary|array $topicFilter): self
    {
        $self = clone $this;
        $self['topicFilter'] = $topicFilter;

        return $self;
    }
}
