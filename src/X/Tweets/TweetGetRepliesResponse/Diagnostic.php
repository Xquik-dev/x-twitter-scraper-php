<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetGetRepliesResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Tweets\TweetGetRepliesResponse\Diagnostic\Richness;
use XTwitterScraper\X\Tweets\TweetGetRepliesResponse\Diagnostic\StrategiesAttempted;

/**
 * Evidence for direct-reply coverage and collector behavior.
 *
 * @phpstan-import-type RichnessShape from \XTwitterScraper\X\Tweets\TweetGetRepliesResponse\Diagnostic\Richness
 * @phpstan-import-type StrategiesAttemptedShape from \XTwitterScraper\X\Tweets\TweetGetRepliesResponse\Diagnostic\StrategiesAttempted
 *
 * @phpstan-type DiagnosticShape = array{
 *   complete: bool,
 *   coveragePercentage: float,
 *   cursorFailures: int,
 *   duplicateCount: int,
 *   emptyFalseProgressPages: int,
 *   malformedCount: int,
 *   missingResponseModulesOrFields: list<string>,
 *   nestedReplyCount: int,
 *   pagesAttempted: int,
 *   recommendedFallback: string,
 *   repeatedCursorCount: int,
 *   reportedReplyCount: int,
 *   responseTruncated: bool,
 *   richness: Richness|RichnessShape,
 *   strategiesAttempted: list<StrategiesAttempted|StrategiesAttemptedShape>,
 *   targetDirectReplies: int,
 *   uniqueDirectReplies: int,
 *   unrelatedCount: int,
 * }
 */
final class Diagnostic implements BaseModel
{
    /** @use SdkModel<DiagnosticShape> */
    use SdkModel;

    /**
     * Whether coverage met the target without truncation.
     */
    #[Required]
    public bool $complete;

    /**
     * Unique direct replies as a percentage of the reported count.
     */
    #[Required]
    public float $coveragePercentage;

    /**
     * Cursor requests that failed.
     */
    #[Required]
    public int $cursorFailures;

    /**
     * Duplicate tweet IDs removed across pages and strategies.
     */
    #[Required]
    public int $duplicateCount;

    /**
     * Empty pages rejected because they did not make progress.
     */
    #[Required]
    public int $emptyFalseProgressPages;

    /**
     * Malformed response items rejected.
     */
    #[Required]
    public int $malformedCount;

    /**
     * Expected response modules or fields missing from X.
     *
     * @var list<string> $missingResponseModulesOrFields
     */
    #[Required(list: 'string')]
    public array $missingResponseModulesOrFields;

    /**
     * Unique nested replies kept outside direct coverage.
     */
    #[Required]
    public int $nestedReplyCount;

    /**
     * Total pages attempted across all strategies.
     */
    #[Required]
    public int $pagesAttempted;

    /**
     * Recommended next action when coverage is incomplete.
     */
    #[Required]
    public string $recommendedFallback;

    /**
     * Repeated cursors rejected to prevent loops.
     */
    #[Required]
    public int $repeatedCursorCount;

    /**
     * Reply count reported on the source post.
     */
    #[Required]
    public int $reportedReplyCount;

    /**
     * Whether the requested row limit truncated safe results.
     */
    #[Required]
    public bool $responseTruncated;

    /**
     * Field-presence counts across the collected direct replies.
     */
    #[Required]
    public Richness $richness;

    /**
     * Per-strategy pagination and contribution evidence.
     *
     * @var list<StrategiesAttempted> $strategiesAttempted
     */
    #[Required(list: StrategiesAttempted::class)]
    public array $strategiesAttempted;

    /**
     * Minimum direct replies required for the coverage target.
     */
    #[Required]
    public int $targetDirectReplies;

    /**
     * Unique replies whose parent ID equals the source post ID.
     */
    #[Required]
    public int $uniqueDirectReplies;

    /**
     * Tweets rejected because they belonged elsewhere.
     */
    #[Required]
    public int $unrelatedCount;

    /**
     * `new Diagnostic()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Diagnostic::with(
     *   complete: ...,
     *   coveragePercentage: ...,
     *   cursorFailures: ...,
     *   duplicateCount: ...,
     *   emptyFalseProgressPages: ...,
     *   malformedCount: ...,
     *   missingResponseModulesOrFields: ...,
     *   nestedReplyCount: ...,
     *   pagesAttempted: ...,
     *   recommendedFallback: ...,
     *   repeatedCursorCount: ...,
     *   reportedReplyCount: ...,
     *   responseTruncated: ...,
     *   richness: ...,
     *   strategiesAttempted: ...,
     *   targetDirectReplies: ...,
     *   uniqueDirectReplies: ...,
     *   unrelatedCount: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Diagnostic)
     *   ->withComplete(...)
     *   ->withCoveragePercentage(...)
     *   ->withCursorFailures(...)
     *   ->withDuplicateCount(...)
     *   ->withEmptyFalseProgressPages(...)
     *   ->withMalformedCount(...)
     *   ->withMissingResponseModulesOrFields(...)
     *   ->withNestedReplyCount(...)
     *   ->withPagesAttempted(...)
     *   ->withRecommendedFallback(...)
     *   ->withRepeatedCursorCount(...)
     *   ->withReportedReplyCount(...)
     *   ->withResponseTruncated(...)
     *   ->withRichness(...)
     *   ->withStrategiesAttempted(...)
     *   ->withTargetDirectReplies(...)
     *   ->withUniqueDirectReplies(...)
     *   ->withUnrelatedCount(...)
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
     * @param list<string> $missingResponseModulesOrFields
     * @param Richness|RichnessShape $richness
     * @param list<StrategiesAttempted|StrategiesAttemptedShape> $strategiesAttempted
     */
    public static function with(
        bool $complete,
        float $coveragePercentage,
        int $cursorFailures,
        int $duplicateCount,
        int $emptyFalseProgressPages,
        int $malformedCount,
        array $missingResponseModulesOrFields,
        int $nestedReplyCount,
        int $pagesAttempted,
        string $recommendedFallback,
        int $repeatedCursorCount,
        int $reportedReplyCount,
        bool $responseTruncated,
        Richness|array $richness,
        array $strategiesAttempted,
        int $targetDirectReplies,
        int $uniqueDirectReplies,
        int $unrelatedCount,
    ): self {
        $self = new self;

        $self['complete'] = $complete;
        $self['coveragePercentage'] = $coveragePercentage;
        $self['cursorFailures'] = $cursorFailures;
        $self['duplicateCount'] = $duplicateCount;
        $self['emptyFalseProgressPages'] = $emptyFalseProgressPages;
        $self['malformedCount'] = $malformedCount;
        $self['missingResponseModulesOrFields'] = $missingResponseModulesOrFields;
        $self['nestedReplyCount'] = $nestedReplyCount;
        $self['pagesAttempted'] = $pagesAttempted;
        $self['recommendedFallback'] = $recommendedFallback;
        $self['repeatedCursorCount'] = $repeatedCursorCount;
        $self['reportedReplyCount'] = $reportedReplyCount;
        $self['responseTruncated'] = $responseTruncated;
        $self['richness'] = $richness;
        $self['strategiesAttempted'] = $strategiesAttempted;
        $self['targetDirectReplies'] = $targetDirectReplies;
        $self['uniqueDirectReplies'] = $uniqueDirectReplies;
        $self['unrelatedCount'] = $unrelatedCount;

        return $self;
    }

    /**
     * Whether coverage met the target without truncation.
     */
    public function withComplete(bool $complete): self
    {
        $self = clone $this;
        $self['complete'] = $complete;

        return $self;
    }

    /**
     * Unique direct replies as a percentage of the reported count.
     */
    public function withCoveragePercentage(float $coveragePercentage): self
    {
        $self = clone $this;
        $self['coveragePercentage'] = $coveragePercentage;

        return $self;
    }

    /**
     * Cursor requests that failed.
     */
    public function withCursorFailures(int $cursorFailures): self
    {
        $self = clone $this;
        $self['cursorFailures'] = $cursorFailures;

        return $self;
    }

    /**
     * Duplicate tweet IDs removed across pages and strategies.
     */
    public function withDuplicateCount(int $duplicateCount): self
    {
        $self = clone $this;
        $self['duplicateCount'] = $duplicateCount;

        return $self;
    }

    /**
     * Empty pages rejected because they did not make progress.
     */
    public function withEmptyFalseProgressPages(
        int $emptyFalseProgressPages
    ): self {
        $self = clone $this;
        $self['emptyFalseProgressPages'] = $emptyFalseProgressPages;

        return $self;
    }

    /**
     * Malformed response items rejected.
     */
    public function withMalformedCount(int $malformedCount): self
    {
        $self = clone $this;
        $self['malformedCount'] = $malformedCount;

        return $self;
    }

    /**
     * Expected response modules or fields missing from X.
     *
     * @param list<string> $missingResponseModulesOrFields
     */
    public function withMissingResponseModulesOrFields(
        array $missingResponseModulesOrFields
    ): self {
        $self = clone $this;
        $self['missingResponseModulesOrFields'] = $missingResponseModulesOrFields;

        return $self;
    }

    /**
     * Unique nested replies kept outside direct coverage.
     */
    public function withNestedReplyCount(int $nestedReplyCount): self
    {
        $self = clone $this;
        $self['nestedReplyCount'] = $nestedReplyCount;

        return $self;
    }

    /**
     * Total pages attempted across all strategies.
     */
    public function withPagesAttempted(int $pagesAttempted): self
    {
        $self = clone $this;
        $self['pagesAttempted'] = $pagesAttempted;

        return $self;
    }

    /**
     * Recommended next action when coverage is incomplete.
     */
    public function withRecommendedFallback(string $recommendedFallback): self
    {
        $self = clone $this;
        $self['recommendedFallback'] = $recommendedFallback;

        return $self;
    }

    /**
     * Repeated cursors rejected to prevent loops.
     */
    public function withRepeatedCursorCount(int $repeatedCursorCount): self
    {
        $self = clone $this;
        $self['repeatedCursorCount'] = $repeatedCursorCount;

        return $self;
    }

    /**
     * Reply count reported on the source post.
     */
    public function withReportedReplyCount(int $reportedReplyCount): self
    {
        $self = clone $this;
        $self['reportedReplyCount'] = $reportedReplyCount;

        return $self;
    }

    /**
     * Whether the requested row limit truncated safe results.
     */
    public function withResponseTruncated(bool $responseTruncated): self
    {
        $self = clone $this;
        $self['responseTruncated'] = $responseTruncated;

        return $self;
    }

    /**
     * Field-presence counts across the collected direct replies.
     *
     * @param Richness|RichnessShape $richness
     */
    public function withRichness(Richness|array $richness): self
    {
        $self = clone $this;
        $self['richness'] = $richness;

        return $self;
    }

    /**
     * Per-strategy pagination and contribution evidence.
     *
     * @param list<StrategiesAttempted|StrategiesAttemptedShape> $strategiesAttempted
     */
    public function withStrategiesAttempted(array $strategiesAttempted): self
    {
        $self = clone $this;
        $self['strategiesAttempted'] = $strategiesAttempted;

        return $self;
    }

    /**
     * Minimum direct replies required for the coverage target.
     */
    public function withTargetDirectReplies(int $targetDirectReplies): self
    {
        $self = clone $this;
        $self['targetDirectReplies'] = $targetDirectReplies;

        return $self;
    }

    /**
     * Unique replies whose parent ID equals the source post ID.
     */
    public function withUniqueDirectReplies(int $uniqueDirectReplies): self
    {
        $self = clone $this;
        $self['uniqueDirectReplies'] = $uniqueDirectReplies;

        return $self;
    }

    /**
     * Tweets rejected because they belonged elsewhere.
     */
    public function withUnrelatedCount(int $unrelatedCount): self
    {
        $self = clone $this;
        $self['unrelatedCount'] = $unrelatedCount;

        return $self;
    }
}
