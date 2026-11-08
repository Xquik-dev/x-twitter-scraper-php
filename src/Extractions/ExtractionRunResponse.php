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
use XTwitterScraper\Extractions\ExtractionRunResponse\Status;
use XTwitterScraper\ExtractionToolType;

/**
 * @phpstan-type ExtractionRunResponseShape = array{
 *   allowed: bool,
 *   creditsAvailable: string,
 *   creditsRequired: string,
 *   estimatedResults: int,
 *   source: string,
 *   resolvedXUserID?: string|null,
 *   id?: string|null,
 *   url?: string|null,
 *   pollAfterMs?: int|null,
 *   statusUrl?: string|null,
 *   waitUrl?: string|null,
 *   toolType?: ExtractionToolType|value-of<ExtractionToolType>|null,
 *   status?: Status|value-of<Status>|null,
 * }
 */
final class ExtractionRunResponse implements BaseModel
{
    /** @use SdkModel<ExtractionRunResponseShape> */
    use SdkModel;

    #[Required]
    public bool $allowed;

    #[Required]
    public string $creditsAvailable;

    #[Required]
    public string $creditsRequired;

    #[Required]
    public int $estimatedResults;

    #[Required]
    public string $source;

    #[Optional('resolvedXUserId')]
    public ?string $resolvedXUserID;

    #[Optional]
    public ?string $id;

    /**
     * Dashboard page of the job. A signed-in user follows its progress there and downloads every row as CSV, XLSX, JSON, Markdown, PDF or text, so give this link to a person who wants the whole list as a file.
     */
    #[Optional]
    public ?string $url;

    #[Optional]
    public ?int $pollAfterMs;

    #[Optional]
    public ?string $statusUrl;

    #[Optional]
    public ?string $waitUrl;

    /**
     * Identifier for the extraction tool used to run a job.
     *
     * @var value-of<ExtractionToolType>|null $toolType
     */
    #[Optional(enum: ExtractionToolType::class)]
    public ?string $toolType;

    /**
     * @var value-of<Status>|null $status
     */
    #[Optional(enum: Status::class)]
    public ?string $status;

    /**
     * `new ExtractionRunResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExtractionRunResponse::with(
     *   allowed: ...,
     *   creditsAvailable: ...,
     *   creditsRequired: ...,
     *   estimatedResults: ...,
     *   source: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExtractionRunResponse)
     *   ->withAllowed(...)
     *   ->withCreditsAvailable(...)
     *   ->withCreditsRequired(...)
     *   ->withEstimatedResults(...)
     *   ->withSource(...)
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
     * @param ExtractionToolType|value-of<ExtractionToolType>|null $toolType
     * @param Status|value-of<Status>|null $status
     */
    public static function with(
        bool $allowed,
        string $creditsAvailable,
        string $creditsRequired,
        int $estimatedResults,
        string $source,
        ?string $resolvedXUserID = null,
        ?string $id = null,
        ?string $url = null,
        ?int $pollAfterMs = null,
        ?string $statusUrl = null,
        ?string $waitUrl = null,
        ExtractionToolType|string|null $toolType = null,
        Status|string|null $status = null
    ): self {
        $self = new self;

        $self['allowed'] = $allowed;
        $self['creditsAvailable'] = $creditsAvailable;
        $self['creditsRequired'] = $creditsRequired;
        $self['estimatedResults'] = $estimatedResults;
        $self['source'] = $source;

        null !== $resolvedXUserID && $self['resolvedXUserID'] = $resolvedXUserID;

        null !== $id && $self['id'] = $id;

        null !== $url && $self['url'] = $url;

        null !== $pollAfterMs && $self['pollAfterMs'] = $pollAfterMs;

        null !== $statusUrl && $self['statusUrl'] = $statusUrl;

        null !== $waitUrl && $self['waitUrl'] = $waitUrl;

        null !== $toolType && $self['toolType'] = $toolType;

        null !== $status && $self['status'] = $status;

        return $self;
    }

    public function withAllowed(bool $allowed): self
    {
        $self = clone $this;
        $self['allowed'] = $allowed;

        return $self;
    }

    public function withCreditsAvailable(string $creditsAvailable): self
    {
        $self = clone $this;
        $self['creditsAvailable'] = $creditsAvailable;

        return $self;
    }

    public function withCreditsRequired(string $creditsRequired): self
    {
        $self = clone $this;
        $self['creditsRequired'] = $creditsRequired;

        return $self;
    }

    public function withEstimatedResults(int $estimatedResults): self
    {
        $self = clone $this;
        $self['estimatedResults'] = $estimatedResults;

        return $self;
    }

    public function withSource(string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    public function withResolvedXUserID(string $resolvedXUserID): self
    {
        $self = clone $this;
        $self['resolvedXUserID'] = $resolvedXUserID;

        return $self;
    }

    public function withId(?string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Dashboard page of the job. A signed-in user follows its progress there and downloads every row as CSV, XLSX, JSON, Markdown, PDF or text, so give this link to a person who wants the whole list as a file.
     */
    public function withUrl(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    public function withPollAfterMs(?int $pollAfterMs): self
    {
        $self = clone $this;
        $self['pollAfterMs'] = $pollAfterMs;

        return $self;
    }

    public function withStatusUrl(?string $statusUrl): self
    {
        $self = clone $this;
        $self['statusUrl'] = $statusUrl;

        return $self;
    }

    public function withWaitUrl(?string $waitUrl): self
    {
        $self = clone $this;
        $self['waitUrl'] = $waitUrl;

        return $self;
    }

    /**
     * Identifier for the extraction tool used to run a job.
     *
     * @param ExtractionToolType|value-of<ExtractionToolType>|null $toolType
     */
    public function withToolType(ExtractionToolType|string|null $toolType): self
    {
        $self = clone $this;
        $self['toolType'] = $toolType;

        return $self;
    }

    /**
     * @param Status|value-of<Status>|null $status
     */
    public function withStatus(Status|string|null $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
