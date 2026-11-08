<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Analysis;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\TweetAnalysisSettings;
use XTwitterScraper\X\Analysis\AnalysisViralScoreParams\Baseline;
use XTwitterScraper\X\Analysis\AnalysisViralScoreParams\QueryType;

/**
 * Answers each post's hook, clarity, payoff, humor, spam risk & likely reaction, & adds a Viral Score from 0 to 100 with a verdict. The score rates the wording. It does not predict likes or views. Send drafts in texts to score them before posting. Each analyzed post costs 2 credits.
 *
 * @see XTwitterScraper\Services\X\AnalysisService::viralScore()
 *
 * @phpstan-type AnalysisViralScoreParamsShape = array{
 *   tweetIDs?: list<string>|null,
 *   query?: string|null,
 *   username?: string|null,
 *   listID?: string|null,
 *   quotesOf?: string|null,
 *   repliesTo?: string|null,
 *   sinceTime?: mixed,
 *   untilTime?: mixed,
 *   queryType?: QueryType|value-of<QueryType>|null,
 *   limit?: int|null,
 *   cursor?: string|null,
 *   texts?: list<string>|null,
 *   analysis?: TweetAnalysisSettings|array<string,mixed>|null,
 *   baseline?: list<Baseline|array<string,mixed>>|null,
 * }
 */
final class AnalysisViralScoreParams implements BaseModel
{
    /** @use SdkModel<AnalysisViralScoreParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Post IDs or post URLs to analyze, up to 100.
     *
     * @var list<string>|null $tweetIDs
     */
    #[Optional('tweetIds', list: 'string')]
    public ?array $tweetIDs;

    /**
     * X search to analyze, with the operators of /x/tweets/search, such as from:nasa or lang:en. X searches up to 512 characters, counted with the other search fields, as /x/tweets/search counts q.
     */
    #[Optional]
    public ?string $query;

    /**
     * Analyze 1 account's posts. Send a handle, with or without @, or a profile URL.
     */
    #[Optional]
    public ?string $username;

    /**
     * Analyze a public List's posts. Send its ID or URL.
     */
    #[Optional('listId')]
    public ?string $listID;

    /**
     * Analyze the quotes of 1 post. Send its ID or URL.
     */
    #[Optional]
    public ?string $quotesOf;

    /**
     * Analyze the replies in 1 post's conversation. Send its ID or URL.
     */
    #[Optional]
    public ?string $repliesTo;

    /**
     * Inclusive start of the search, such as 2026-09-25T00:00:00Z. Unix seconds also work. A time without an offset is UTC.
     */
    #[Optional]
    public mixed $sinceTime;

    /**
     * Exclusive end of the search, such as 2026-09-26T00:00:00Z. Unix seconds also work. A time without an offset is UTC.
     */
    #[Optional]
    public mixed $untilTime;

    /**
     * Search order. Default Latest.
     *
     * @var value-of<QueryType>|null $queryType
     */
    #[Optional(enum: QueryType::class)]
    public ?string $queryType;

    /**
     * Maximum posts to analyze from the search. A low credit balance can return fewer.
     */
    #[Optional]
    public ?int $limit;

    /**
     * The next_cursor of the page before. Send the same search with it.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Your own texts to analyze, such as drafts. Reads nothing from X. Each text costs the same as 1 analyzed post.
     *
     * @var list<string>|null $texts
     */
    #[Optional(list: 'string')]
    public ?array $texts;

    /**
     * Analysis settings, the same as the analysis input of Xquik's AI Actors, plus images. Leave it out for the route's own questions.
     */
    #[Optional]
    public ?TweetAnalysisSettings $analysis;

    /**
     * Rows of an earlier answer to compare with, such as its results. Each needs the post's id, or tweet.id, & its answers. Send monitor too, so other settings show as not_comparable. Each result's monitor says whether the post is new, changed or unchanged. The comparison costs nothing extra.
     *
     * @var list<Baseline>|null $baseline
     */
    #[Optional(list: Baseline::class)]
    public ?array $baseline;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $tweetIDs
     * @param QueryType|value-of<QueryType>|null $queryType
     * @param list<string>|null $texts
     * @param TweetAnalysisSettings|array<string,mixed>|null $analysis
     * @param list<Baseline|array<string,mixed>>|null $baseline
     */
    public static function with(?array $tweetIDs = null, ?string $query = null, ?string $username = null, ?string $listID = null, ?string $quotesOf = null, ?string $repliesTo = null, mixed $sinceTime = null, mixed $untilTime = null, QueryType|string|null $queryType = null, ?int $limit = null, ?string $cursor = null, ?array $texts = null, TweetAnalysisSettings|array|null $analysis = null, ?array $baseline = null): self
    {
        $self = new self;

        null !== $tweetIDs && $self['tweetIDs'] = $tweetIDs;
        null !== $query && $self['query'] = $query;
        null !== $username && $self['username'] = $username;
        null !== $listID && $self['listID'] = $listID;
        null !== $quotesOf && $self['quotesOf'] = $quotesOf;
        null !== $repliesTo && $self['repliesTo'] = $repliesTo;
        null !== $sinceTime && $self['sinceTime'] = $sinceTime;
        null !== $untilTime && $self['untilTime'] = $untilTime;
        null !== $queryType && $self['queryType'] = $queryType;
        null !== $limit && $self['limit'] = $limit;
        null !== $cursor && $self['cursor'] = $cursor;
        null !== $texts && $self['texts'] = $texts;
        null !== $analysis && $self['analysis'] = $analysis;
        null !== $baseline && $self['baseline'] = $baseline;

        return $self;
    }

    /**
     * Post IDs or post URLs to analyze, up to 100.
     *
     * @param list<string>|null $tweetIDs
     */
    public function withTweetIDs(?array $tweetIDs): self
    {
        $self = clone $this;
        $self['tweetIDs'] = $tweetIDs;

        return $self;
    }

    /**
     * X search to analyze, with the operators of /x/tweets/search, such as from:nasa or lang:en. X searches up to 512 characters, counted with the other search fields, as /x/tweets/search counts q.
     */
    public function withQuery(?string $query): self
    {
        $self = clone $this;
        $self['query'] = $query;

        return $self;
    }

    /**
     * Analyze 1 account's posts. Send a handle, with or without @, or a profile URL.
     */
    public function withUsername(?string $username): self
    {
        $self = clone $this;
        $self['username'] = $username;

        return $self;
    }

    /**
     * Analyze a public List's posts. Send its ID or URL.
     */
    public function withListID(?string $listID): self
    {
        $self = clone $this;
        $self['listID'] = $listID;

        return $self;
    }

    /**
     * Analyze the quotes of 1 post. Send its ID or URL.
     */
    public function withQuotesOf(?string $quotesOf): self
    {
        $self = clone $this;
        $self['quotesOf'] = $quotesOf;

        return $self;
    }

    /**
     * Analyze the replies in 1 post's conversation. Send its ID or URL.
     */
    public function withRepliesTo(?string $repliesTo): self
    {
        $self = clone $this;
        $self['repliesTo'] = $repliesTo;

        return $self;
    }

    /**
     * Inclusive start of the search, such as 2026-09-25T00:00:00Z. Unix seconds also work. A time without an offset is UTC.
     */
    public function withSinceTime(mixed $sinceTime): self
    {
        $self = clone $this;
        $self['sinceTime'] = $sinceTime;

        return $self;
    }

    /**
     * Exclusive end of the search, such as 2026-09-26T00:00:00Z. Unix seconds also work. A time without an offset is UTC.
     */
    public function withUntilTime(mixed $untilTime): self
    {
        $self = clone $this;
        $self['untilTime'] = $untilTime;

        return $self;
    }

    /**
     * Search order. Default Latest.
     *
     * @param QueryType|value-of<QueryType>|null $queryType
     */
    public function withQueryType(QueryType|string|null $queryType): self
    {
        $self = clone $this;
        $self['queryType'] = $queryType;

        return $self;
    }

    /**
     * Maximum posts to analyze from the search. A low credit balance can return fewer.
     */
    public function withLimit(?int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * The next_cursor of the page before. Send the same search with it.
     */
    public function withCursor(?string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Your own texts to analyze, such as drafts. Reads nothing from X. Each text costs the same as 1 analyzed post.
     *
     * @param list<string>|null $texts
     */
    public function withTexts(?array $texts): self
    {
        $self = clone $this;
        $self['texts'] = $texts;

        return $self;
    }

    /**
     * Analysis settings, the same as the analysis input of Xquik's AI Actors, plus images. Leave it out for the route's own questions.
     *
     * @param TweetAnalysisSettings|array<string,mixed>|null $analysis
     */
    public function withAnalysis(TweetAnalysisSettings|array|null $analysis): self
    {
        $self = clone $this;
        $self['analysis'] = $analysis;

        return $self;
    }

    /**
     * Rows of an earlier answer to compare with, such as its results. Each needs the post's id, or tweet.id, & its answers. Send monitor too, so other settings show as not_comparable. Each result's monitor says whether the post is new, changed or unchanged. The comparison costs nothing extra.
     *
     * @param list<Baseline|array<string,mixed>>|null $baseline
     */
    public function withBaseline(?array $baseline): self
    {
        $self = clone $this;
        $self['baseline'] = $baseline;

        return $self;
    }
}
