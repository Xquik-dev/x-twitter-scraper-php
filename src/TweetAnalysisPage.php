<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TweetAnalysisPageShape = array{
 *   results: list<TweetAnalysisResult|array<string,mixed>>,
 *   unanalyzed: list<UnanalyzedTweet|array<string,mixed>>,
 *   analysisSummary: TweetAnalysisSummary|array<string,mixed>,
 *   hasNextPage: bool,
 *   nextCursor: string,
 * }
 */
final class TweetAnalysisPage implements BaseModel
{
    /** @use SdkModel<TweetAnalysisPageShape> */
    use SdkModel;

    /**
     * Each analyzed post with its answers.
     *
     * @var list<TweetAnalysisResult> $results
     */
    #[Required(list: TweetAnalysisResult::class)]
    public array $results;

    /**
     * Each post without an analysis, by ID & reason. These cost nothing.
     *
     * @var list<UnanalyzedTweet> $unanalyzed
     */
    #[Required(list: UnanalyzedTweet::class)]
    public array $unanalyzed;

    /**
     * Totals of the answers across the analyzed posts.
     */
    #[Required]
    public TweetAnalysisSummary $analysisSummary;

    /**
     * Whether the search has more posts. Send next_cursor as cursor.
     */
    #[Required('has_next_page')]
    public bool $hasNextPage;

    /**
     * Cursor of the search's next page, else empty.
     */
    #[Required('next_cursor')]
    public string $nextCursor;

    /**
     * `new TweetAnalysisPage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetAnalysisPage::with(results: ..., unanalyzed: ..., analysisSummary: ..., hasNextPage: ..., nextCursor: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetAnalysisPage)->withResults(...)->withUnanalyzed(...)->withAnalysisSummary(...)->withHasNextPage(...)->withNextCursor(...)
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
     * @param list<TweetAnalysisResult|array<string,mixed>> $results
     * @param list<UnanalyzedTweet|array<string,mixed>> $unanalyzed
     * @param TweetAnalysisSummary|array<string,mixed> $analysisSummary
     */
    public static function with(array $results, array $unanalyzed, TweetAnalysisSummary|array $analysisSummary, bool $hasNextPage, string $nextCursor): self
    {
        $self = new self;

        $self['results'] = $results;
        $self['unanalyzed'] = $unanalyzed;
        $self['analysisSummary'] = $analysisSummary;
        $self['hasNextPage'] = $hasNextPage;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * Each analyzed post with its answers.
     *
     * @param list<TweetAnalysisResult|array<string,mixed>> $results
     */
    public function withResults(array $results): self
    {
        $self = clone $this;
        $self['results'] = $results;

        return $self;
    }

    /**
     * Each post without an analysis, by ID & reason. These cost nothing.
     *
     * @param list<UnanalyzedTweet|array<string,mixed>> $unanalyzed
     */
    public function withUnanalyzed(array $unanalyzed): self
    {
        $self = clone $this;
        $self['unanalyzed'] = $unanalyzed;

        return $self;
    }

    /**
     * Totals of the answers across the analyzed posts.
     *
     * @param TweetAnalysisSummary|array<string,mixed> $analysisSummary
     */
    public function withAnalysisSummary(TweetAnalysisSummary|array $analysisSummary): self
    {
        $self = clone $this;
        $self['analysisSummary'] = $analysisSummary;

        return $self;
    }

    /**
     * Whether the search has more posts. Send next_cursor as cursor.
     */
    public function withHasNextPage(bool $hasNextPage): self
    {
        $self = clone $this;
        $self['hasNextPage'] = $hasNextPage;

        return $self;
    }

    /**
     * Cursor of the search's next page, else empty.
     */
    public function withNextCursor(string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }
}
