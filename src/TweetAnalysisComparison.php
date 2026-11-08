<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\TweetAnalysisComparison\Changes;
use XTwitterScraper\TweetAnalysisComparison\Status;

/**
 * @phpstan-type TweetAnalysisComparisonShape = array{
 *   configurationFingerprint: string,
 *   baselineDatasetID: mixed,
 *   status: Status|value-of<Status>,
 *   changedQuestionIDs: list<string>,
 *   changes: list<Changes|array<string,mixed>>,
 * }
 */
final class TweetAnalysisComparison implements BaseModel
{
    /** @use SdkModel<TweetAnalysisComparisonShape> */
    use SdkModel;

    /**
     * Hash of the questions, targets & context. Rows with another hash are not_comparable.
     */
    #[Required]
    public string $configurationFingerprint;

    /**
     * Always null. The baseline is the rows you sent.
     */
    #[Required('baselineDatasetId')]
    public mixed $baselineDatasetID;

    /**
     * first_run without baseline. new_to_baseline for a post baseline lacks. changed when an answer clearly left its earlier decision. not_comparable when other settings made the earlier row or it answers none of these questions.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * IDs of the questions whose decision changed.
     *
     * @var list<string> $changedQuestionIDs
     */
    #[Required('changedQuestionIds', list: 'string')]
    public array $changedQuestionIDs;

    /**
     * Each changed decision, earlier & now.
     *
     * @var list<Changes> $changes
     */
    #[Required(list: Changes::class)]
    public array $changes;

    /**
     * `new TweetAnalysisComparison()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetAnalysisComparison::with(configurationFingerprint: ..., baselineDatasetID: ..., status: ..., changedQuestionIDs: ..., changes: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetAnalysisComparison)->withConfigurationFingerprint(...)->withBaselineDatasetID(...)->withStatus(...)->withChangedQuestionIDs(...)->withChanges(...)
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
     * @param Status|value-of<Status> $status
     * @param list<string> $changedQuestionIDs
     * @param list<Changes|array<string,mixed>> $changes
     */
    public static function with(string $configurationFingerprint, mixed $baselineDatasetID, Status|string $status, array $changedQuestionIDs, array $changes): self
    {
        $self = new self;

        $self['configurationFingerprint'] = $configurationFingerprint;
        $self['baselineDatasetID'] = $baselineDatasetID;
        $self['status'] = $status;
        $self['changedQuestionIDs'] = $changedQuestionIDs;
        $self['changes'] = $changes;

        return $self;
    }

    /**
     * Hash of the questions, targets & context. Rows with another hash are not_comparable.
     */
    public function withConfigurationFingerprint(string $configurationFingerprint): self
    {
        $self = clone $this;
        $self['configurationFingerprint'] = $configurationFingerprint;

        return $self;
    }

    /**
     * Always null. The baseline is the rows you sent.
     */
    public function withBaselineDatasetID(mixed $baselineDatasetID): self
    {
        $self = clone $this;
        $self['baselineDatasetID'] = $baselineDatasetID;

        return $self;
    }

    /**
     * first_run without baseline. new_to_baseline for a post baseline lacks. changed when an answer clearly left its earlier decision. not_comparable when other settings made the earlier row or it answers none of these questions.
     *
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * IDs of the questions whose decision changed.
     *
     * @param list<string> $changedQuestionIDs
     */
    public function withChangedQuestionIDs(array $changedQuestionIDs): self
    {
        $self = clone $this;
        $self['changedQuestionIDs'] = $changedQuestionIDs;

        return $self;
    }

    /**
     * Each changed decision, earlier & now.
     *
     * @param list<Changes|array<string,mixed>> $changes
     */
    public function withChanges(array $changes): self
    {
        $self = clone $this;
        $self['changes'] = $changes;

        return $self;
    }
}
