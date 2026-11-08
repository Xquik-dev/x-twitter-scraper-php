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
use XTwitterScraper\TweetAnalysisResult\Analysis;
use XTwitterScraper\TweetAnalysisResult\ViralVerdict;

/**
 * @phpstan-type TweetAnalysisResultShape = array{
 *   tweet: SearchTweet2|array<string,mixed>,
 *   analysis: Analysis|array<string,mixed>,
 *   answers: array<string,mixed>,
 *   sourceDomains: list<string>,
 *   cashtags: list<string>,
 *   monitor: TweetAnalysisComparison|array<string,mixed>,
 *   viralScore?: int|null,
 *   viralVerdict?: ViralVerdict|value-of<ViralVerdict>|null,
 *   viralAlgorithmScore?: float|null,
 *   viralActualEngagementRate?: float|null,
 *   viral?: array<string,mixed>|null,
 * }
 */
final class TweetAnalysisResult implements BaseModel
{
    /** @use SdkModel<TweetAnalysisResultShape> */
    use SdkModel;

    /**
     * The post, as /x/tweets/search returns it. Your own texts have the IDs text:1, text:2 & so on.
     */
    #[Required]
    public SearchTweet2 $tweet;

    /**
     * The answers in full, with their probabilities.
     */
    #[Required]
    public Analysis $analysis;

    /**
     * Each question's decision by question ID. A choice gives its category, a score its level from 0, which can have decimals, & a probability its value from 0 to 1.
     *
     * @var array<string,mixed> $answers
     */
    #[Required(map: 'mixed')]
    public array $answers;

    /**
     * Hostnames the post links to, without t.co.
     *
     * @var list<string> $sourceDomains
     */
    #[Required(list: 'string')]
    public array $sourceDomains;

    /**
     * Cashtags in the post's text, in upper case.
     *
     * @var list<string> $cashtags
     */
    #[Required(list: 'string')]
    public array $cashtags;

    /**
     * How the post's answers compare with its row in baseline, as the AI Actors compare a run with an earlier dataset.
     */
    #[Required]
    public TweetAnalysisComparison $monitor;

    /**
     * Only from /x/analysis/viral-score. How viral the wording reads, or null when a trait has no answer.
     */
    #[Optional(nullable: true)]
    public ?int $viralScore;

    /**
     * Only from /x/analysis/viral-score. send_it from 70, edit_first from 40, else sleep_on_it.
     *
     * @var value-of<ViralVerdict>|null $viralVerdict
     */
    #[Optional(enum: ViralVerdict::class, nullable: true)]
    public ?string $viralVerdict;

    /**
     * Only from /x/analysis/viral-score. The post's public counts under X's published ranking weights, per 1,000 views or followers.
     */
    #[Optional(nullable: true)]
    public ?float $viralAlgorithmScore;

    /**
     * Only from /x/analysis/viral-score. log10 of 1 plus the weighted engagement per 1,000 followers. Null without a follower count.
     */
    #[Optional(nullable: true)]
    public ?float $viralActualEngagementRate;

    /**
     * Only from /x/analysis/viral-score. The score with its weights version, the caps that applied & the engagement comparison.
     *
     * @var array<string,mixed>|null $viral
     */
    #[Optional(map: 'mixed')]
    public ?array $viral;

    /**
     * `new TweetAnalysisResult()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetAnalysisResult::with(tweet: ..., analysis: ..., answers: ..., sourceDomains: ..., cashtags: ..., monitor: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetAnalysisResult)->withTweet(...)->withAnalysis(...)->withAnswers(...)->withSourceDomains(...)->withCashtags(...)->withMonitor(...)
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
     * @param SearchTweet2|array<string,mixed> $tweet
     * @param Analysis|array<string,mixed> $analysis
     * @param array<string,mixed> $answers
     * @param list<string> $sourceDomains
     * @param list<string> $cashtags
     * @param TweetAnalysisComparison|array<string,mixed> $monitor
     * @param ViralVerdict|value-of<ViralVerdict>|null $viralVerdict
     * @param array<string,mixed>|null $viral
     */
    public static function with(SearchTweet2|array $tweet, Analysis|array $analysis, array $answers, array $sourceDomains, array $cashtags, TweetAnalysisComparison|array $monitor, ?int $viralScore = null, ViralVerdict|string|null $viralVerdict = null, ?float $viralAlgorithmScore = null, ?float $viralActualEngagementRate = null, ?array $viral = null): self
    {
        $self = new self;

        $self['tweet'] = $tweet;
        $self['analysis'] = $analysis;
        $self['answers'] = $answers;
        $self['sourceDomains'] = $sourceDomains;
        $self['cashtags'] = $cashtags;
        $self['monitor'] = $monitor;

        null !== $viralScore && $self['viralScore'] = $viralScore;
        null !== $viralVerdict && $self['viralVerdict'] = $viralVerdict;
        null !== $viralAlgorithmScore && $self['viralAlgorithmScore'] = $viralAlgorithmScore;
        null !== $viralActualEngagementRate && $self['viralActualEngagementRate'] = $viralActualEngagementRate;
        null !== $viral && $self['viral'] = $viral;

        return $self;
    }

    /**
     * The post, as /x/tweets/search returns it. Your own texts have the IDs text:1, text:2 & so on.
     *
     * @param SearchTweet2|array<string,mixed> $tweet
     */
    public function withTweet(SearchTweet2|array $tweet): self
    {
        $self = clone $this;
        $self['tweet'] = $tweet;

        return $self;
    }

    /**
     * The answers in full, with their probabilities.
     *
     * @param Analysis|array<string,mixed> $analysis
     */
    public function withAnalysis(Analysis|array $analysis): self
    {
        $self = clone $this;
        $self['analysis'] = $analysis;

        return $self;
    }

    /**
     * Each question's decision by question ID. A choice gives its category, a score its level from 0, which can have decimals, & a probability its value from 0 to 1.
     *
     * @param array<string,mixed> $answers
     */
    public function withAnswers(array $answers): self
    {
        $self = clone $this;
        $self['answers'] = $answers;

        return $self;
    }

    /**
     * Hostnames the post links to, without t.co.
     *
     * @param list<string> $sourceDomains
     */
    public function withSourceDomains(array $sourceDomains): self
    {
        $self = clone $this;
        $self['sourceDomains'] = $sourceDomains;

        return $self;
    }

    /**
     * Cashtags in the post's text, in upper case.
     *
     * @param list<string> $cashtags
     */
    public function withCashtags(array $cashtags): self
    {
        $self = clone $this;
        $self['cashtags'] = $cashtags;

        return $self;
    }

    /**
     * How the post's answers compare with its row in baseline, as the AI Actors compare a run with an earlier dataset.
     *
     * @param TweetAnalysisComparison|array<string,mixed> $monitor
     */
    public function withMonitor(TweetAnalysisComparison|array $monitor): self
    {
        $self = clone $this;
        $self['monitor'] = $monitor;

        return $self;
    }

    /**
     * Only from /x/analysis/viral-score. How viral the wording reads, or null when a trait has no answer.
     */
    public function withViralScore(?int $viralScore): self
    {
        $self = clone $this;
        $self['viralScore'] = $viralScore;

        return $self;
    }

    /**
     * Only from /x/analysis/viral-score. send_it from 70, edit_first from 40, else sleep_on_it.
     *
     * @param ViralVerdict|value-of<ViralVerdict>|null $viralVerdict
     */
    public function withViralVerdict(ViralVerdict|string|null $viralVerdict): self
    {
        $self = clone $this;
        $self['viralVerdict'] = $viralVerdict;

        return $self;
    }

    /**
     * Only from /x/analysis/viral-score. The post's public counts under X's published ranking weights, per 1,000 views or followers.
     */
    public function withViralAlgorithmScore(?float $viralAlgorithmScore): self
    {
        $self = clone $this;
        $self['viralAlgorithmScore'] = $viralAlgorithmScore;

        return $self;
    }

    /**
     * Only from /x/analysis/viral-score. log10 of 1 plus the weighted engagement per 1,000 followers. Null without a follower count.
     */
    public function withViralActualEngagementRate(?float $viralActualEngagementRate): self
    {
        $self = clone $this;
        $self['viralActualEngagementRate'] = $viralActualEngagementRate;

        return $self;
    }

    /**
     * Only from /x/analysis/viral-score. The score with its weights version, the caps that applied & the engagement comparison.
     *
     * @param array<string,mixed>|null $viral
     */
    public function withViral(?array $viral): self
    {
        $self = clone $this;
        $self['viral'] = $viral;

        return $self;
    }
}
