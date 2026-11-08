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
use XTwitterScraper\Extractions\ExtractionJob\Status;
use XTwitterScraper\Extractions\ExtractionJob\ToolType;
use XTwitterScraper\ImageFilterSummary;
use XTwitterScraper\TopicFilterSummary;

/**
 * Extraction job tracking status, tool type, and result count.
 *
 * @phpstan-import-type ImageFilterSummaryShape from \XTwitterScraper\ImageFilterSummary
 * @phpstan-import-type TopicFilterSummaryShape from \XTwitterScraper\TopicFilterSummary
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
}
