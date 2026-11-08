<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Extractions;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Extractions\ExtractionJob\CompletionReason;
use XTwitterScraper\Extractions\ExtractionJob\Status;
use XTwitterScraper\Extractions\ExtractionJob\ToolType;
use XTwitterScraper\ImageFilterSummary;
use XTwitterScraper\TopicFilterSummary;

/**
 * Extraction job tracking status, tool type, and result count.
 *
 * @phpstan-import-type ImageFilterSummaryShape from ImageFilterSummary
 * @phpstan-import-type TopicFilterSummaryShape from TopicFilterSummary
 *
 * @phpstan-type ExtractionJobShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   status: Status|value-of<Status>,
 *   toolType: ToolType|value-of<ToolType>,
 *   totalResults: int,
 *   completedAt?: \DateTimeInterface|null,
 *   imageFilter?: null|ImageFilterSummary|ImageFilterSummaryShape,
 *   topicFilter?: null|TopicFilterSummary|TopicFilterSummaryShape,
 *   url?: string|null,
 *   resultsLimit?: int|null,
 *   effectiveResultsLimit?: int|null,
 *   completionReason?: CompletionReason|value-of<CompletionReason>|null,
 *   errorMessage?: string|null,
 * }
 */
final class ExtractionJob implements BaseModel
{
    /** @use SdkModel<ExtractionJobShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    /** @var value-of<Status> $status */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * Identifier for the extraction tool used to run a job.
     *
     * @var value-of<ToolType> $toolType
     */
    #[Required(enum: ToolType::class)]
    public string $toolType;

    #[Required]
    public int $totalResults;

    #[Optional]
    public ?\DateTimeInterface $completedAt;

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
     * Dashboard page where a signed-in user follows this job & downloads its rows as CSV, XLSX, JSON, Markdown, PDF or text.
     */
    #[Optional]
    public ?string $url;

    /**
     * Requested result limit.
     */
    #[Optional]
    public ?int $resultsLimit;

    /**
     * Result limit after affordability checks.
     */
    #[Optional]
    public ?int $effectiveResultsLimit;

    /**
     * Why a terminal job stopped. `requested_limit_reached` means the job returned the number of results you asked for. `source_exhausted` means the read reached its end before your limit. A search can reach its end with only part of its matches. Wide date windows return fewer posts than narrow ones over the same dates. For a fuller collection, run the same search in shorter windows. `pagination_safety_limit` means a paging safety rule ended the read early. The job keeps every result it found. `deadline_reached` means the job ran out of time. `partial_failure` means some reads failed, and the job keeps the results from the rest. `budget_limited` means your credits covered fewer results than the job found. `canceled` and `failed` match the job status.
     *
     * @var value-of<CompletionReason>|null $completionReason
     */
    #[Optional(enum: CompletionReason::class)]
    public ?string $completionReason;

    /**
     * Safe error code for a failed job.
     */
    #[Optional]
    public ?string $errorMessage;

    /**
     * `new ExtractionJob()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExtractionJob::with(
     *   id: ..., createdAt: ..., status: ..., toolType: ..., totalResults: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExtractionJob)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withStatus(...)
     *   ->withToolType(...)
     *   ->withTotalResults(...)
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
     * @param ToolType|value-of<ToolType> $toolType
     * @param ImageFilterSummary|ImageFilterSummaryShape|null $imageFilter
     * @param TopicFilterSummary|TopicFilterSummaryShape|null $topicFilter
     * @param CompletionReason|value-of<CompletionReason>|null $completionReason
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        Status|string $status,
        ToolType|string $toolType,
        int $totalResults,
        ?\DateTimeInterface $completedAt = null,
        ImageFilterSummary|array|null $imageFilter = null,
        TopicFilterSummary|array|null $topicFilter = null,
        ?string $url = null,
        ?int $resultsLimit = null,
        ?int $effectiveResultsLimit = null,
        CompletionReason|string|null $completionReason = null,
        ?string $errorMessage = null
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['status'] = $status;
        $self['toolType'] = $toolType;
        $self['totalResults'] = $totalResults;

        null !== $completedAt && $self['completedAt'] = $completedAt;
        null !== $imageFilter && $self['imageFilter'] = $imageFilter;
        null !== $topicFilter && $self['topicFilter'] = $topicFilter;

        null !== $url && $self['url'] = $url;

        null !== $resultsLimit && $self['resultsLimit'] = $resultsLimit;

        null !== $effectiveResultsLimit && $self['effectiveResultsLimit'] = $effectiveResultsLimit;

        null !== $completionReason && $self['completionReason'] = $completionReason;

        null !== $errorMessage && $self['errorMessage'] = $errorMessage;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * Identifier for the extraction tool used to run a job.
     *
     * @param ToolType|value-of<ToolType> $toolType
     */
    public function withToolType(ToolType|string $toolType): self
    {
        $self = clone $this;
        $self['toolType'] = $toolType;

        return $self;
    }

    public function withTotalResults(int $totalResults): self
    {
        $self = clone $this;
        $self['totalResults'] = $totalResults;

        return $self;
    }

    public function withCompletedAt(\DateTimeInterface $completedAt): self
    {
        $self = clone $this;
        $self['completedAt'] = $completedAt;

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

    /**
     * Dashboard page where a signed-in user follows this job & downloads its rows as CSV, XLSX, JSON, Markdown, PDF or text.
     */
    public function withUrl(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Requested result limit.
     */
    public function withResultsLimit(?int $resultsLimit): self
    {
        $self = clone $this;
        $self['resultsLimit'] = $resultsLimit;

        return $self;
    }

    /**
     * Result limit after affordability checks.
     */
    public function withEffectiveResultsLimit(?int $effectiveResultsLimit): self
    {
        $self = clone $this;
        $self['effectiveResultsLimit'] = $effectiveResultsLimit;

        return $self;
    }

    /**
     * Why a terminal job stopped. `requested_limit_reached` means the job returned the number of results you asked for. `source_exhausted` means the read reached its end before your limit. A search can reach its end with only part of its matches. Wide date windows return fewer posts than narrow ones over the same dates. For a fuller collection, run the same search in shorter windows. `pagination_safety_limit` means a paging safety rule ended the read early. The job keeps every result it found. `deadline_reached` means the job ran out of time. `partial_failure` means some reads failed, and the job keeps the results from the rest. `budget_limited` means your credits covered fewer results than the job found. `canceled` and `failed` match the job status.
     *
     * @param CompletionReason|value-of<CompletionReason>|null $completionReason
     */
    public function withCompletionReason(CompletionReason|string|null $completionReason): self
    {
        $self = clone $this;
        $self['completionReason'] = $completionReason;

        return $self;
    }

    /**
     * Safe error code for a failed job.
     */
    public function withErrorMessage(?string $errorMessage): self
    {
        $self = clone $this;
        $self['errorMessage'] = $errorMessage;

        return $self;
    }
}
