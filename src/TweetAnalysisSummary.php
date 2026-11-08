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
use XTwitterScraper\TweetAnalysisSummary\Cashtags;
use XTwitterScraper\TweetAnalysisSummary\Monitor;
use XTwitterScraper\TweetAnalysisSummary\Rows;
use XTwitterScraper\TweetAnalysisSummary\SourceDomains;
use XTwitterScraper\TweetAnalysisSummary\Targets;

/**
 * @phpstan-type TweetAnalysisSummaryShape = array{
 *   schemaVersion: int,
 *   rows: Rows|array<string,mixed>,
 *   engagement: int,
 *   questions: array<string,mixed>,
 *   targets: list<Targets|array<string,mixed>>,
 *   cashtags: list<Cashtags|array<string,mixed>>,
 *   sourceDomains: list<SourceDomains|array<string,mixed>>,
 *   monitor: Monitor|array<string,mixed>|null,
 *   viral?: array<string,mixed>|null,
 * }
 */
final class TweetAnalysisSummary implements BaseModel
{
    /** @use SdkModel<TweetAnalysisSummaryShape> */
    use SdkModel;

    #[Required]
    public int $schemaVersion;

    /**
     * Posts by analysis outcome.
     */
    #[Required]
    public Rows $rows;

    /**
     * Likes, reposts, replies & quotes of the analyzed posts.
     */
    #[Required]
    public int $engagement;

    /**
     * Totals by question ID. A choice has counts, shares, engagementShares & top posts per category. A score has mean, engagementWeightedMean & levels. A probability has mean, yes & no.
     *
     * @var array<string,mixed> $questions
     */
    #[Required(map: 'mixed')]
    public array $questions;

    /**
     * Mentions & answers per target in analysis.targets.
     *
     * @var list<Targets> $targets
     */
    #[Required(list: Targets::class)]
    public array $targets;

    /**
     * Posts & answers per cashtag, most posts first, up to 20. signal is present for the market questions.
     *
     * @var list<Cashtags> $cashtags
     */
    #[Required(list: Cashtags::class)]
    public array $cashtags;

    /**
     * Posts per linked hostname, most posts first, up to 20.
     *
     * @var list<SourceDomains> $sourceDomains
     */
    #[Required(list: SourceDomains::class)]
    public array $sourceDomains;

    /**
     * Posts per comparison status, & up to 50 changed posts with their changes. Null when the answer holds no post.
     */
    #[Required]
    public ?Monitor $monitor;

    /**
     * Only from /x/analysis/viral-score. Scored posts, the average score, verdict counts, the scores against actual engagement, a report per author & the leaderboards.
     *
     * @var array<string,mixed>|null $viral
     */
    #[Optional(map: 'mixed')]
    public ?array $viral;

    /**
     * `new TweetAnalysisSummary()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetAnalysisSummary::with(schemaVersion: ..., rows: ..., engagement: ..., questions: ..., targets: ..., cashtags: ..., sourceDomains: ..., monitor: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetAnalysisSummary)->withSchemaVersion(...)->withRows(...)->withEngagement(...)->withQuestions(...)->withTargets(...)->withCashtags(...)->withSourceDomains(...)->withMonitor(...)
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
     * @param Rows|array<string,mixed> $rows
     * @param array<string,mixed> $questions
     * @param list<Targets|array<string,mixed>> $targets
     * @param list<Cashtags|array<string,mixed>> $cashtags
     * @param list<SourceDomains|array<string,mixed>> $sourceDomains
     * @param Monitor|array<string,mixed>|null $monitor
     * @param array<string,mixed>|null $viral
     */
    public static function with(int $schemaVersion, Rows|array $rows, int $engagement, array $questions, array $targets, array $cashtags, array $sourceDomains, Monitor|array|null $monitor, ?array $viral = null): self
    {
        $self = new self;

        $self['schemaVersion'] = $schemaVersion;
        $self['rows'] = $rows;
        $self['engagement'] = $engagement;
        $self['questions'] = $questions;
        $self['targets'] = $targets;
        $self['cashtags'] = $cashtags;
        $self['sourceDomains'] = $sourceDomains;
        $self['monitor'] = $monitor;

        null !== $viral && $self['viral'] = $viral;

        return $self;
    }

    public function withSchemaVersion(int $schemaVersion): self
    {
        $self = clone $this;
        $self['schemaVersion'] = $schemaVersion;

        return $self;
    }

    /**
     * Posts by analysis outcome.
     *
     * @param Rows|array<string,mixed> $rows
     */
    public function withRows(Rows|array $rows): self
    {
        $self = clone $this;
        $self['rows'] = $rows;

        return $self;
    }

    /**
     * Likes, reposts, replies & quotes of the analyzed posts.
     */
    public function withEngagement(int $engagement): self
    {
        $self = clone $this;
        $self['engagement'] = $engagement;

        return $self;
    }

    /**
     * Totals by question ID. A choice has counts, shares, engagementShares & top posts per category. A score has mean, engagementWeightedMean & levels. A probability has mean, yes & no.
     *
     * @param array<string,mixed> $questions
     */
    public function withQuestions(array $questions): self
    {
        $self = clone $this;
        $self['questions'] = $questions;

        return $self;
    }

    /**
     * Mentions & answers per target in analysis.targets.
     *
     * @param list<Targets|array<string,mixed>> $targets
     */
    public function withTargets(array $targets): self
    {
        $self = clone $this;
        $self['targets'] = $targets;

        return $self;
    }

    /**
     * Posts & answers per cashtag, most posts first, up to 20. signal is present for the market questions.
     *
     * @param list<Cashtags|array<string,mixed>> $cashtags
     */
    public function withCashtags(array $cashtags): self
    {
        $self = clone $this;
        $self['cashtags'] = $cashtags;

        return $self;
    }

    /**
     * Posts per linked hostname, most posts first, up to 20.
     *
     * @param list<SourceDomains|array<string,mixed>> $sourceDomains
     */
    public function withSourceDomains(array $sourceDomains): self
    {
        $self = clone $this;
        $self['sourceDomains'] = $sourceDomains;

        return $self;
    }

    /**
     * Posts per comparison status, & up to 50 changed posts with their changes. Null when the answer holds no post.
     *
     * @param Monitor|array<string,mixed>|null $monitor
     */
    public function withMonitor(Monitor|array|null $monitor): self
    {
        $self = clone $this;
        $self['monitor'] = $monitor;

        return $self;
    }

    /**
     * Only from /x/analysis/viral-score. Scored posts, the average score, verdict counts, the scores against actual engagement, a report per author & the leaderboards.
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
