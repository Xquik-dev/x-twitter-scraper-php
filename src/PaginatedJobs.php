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
 * @phpstan-type PaginatedJobsShape = array{
 *   jobs: list<Job|array<string,mixed>>,
 *   hasNextPage: bool,
 *   nextCursor: string,
 * }
 */
final class PaginatedJobs implements BaseModel
{
    /** @use SdkModel<PaginatedJobsShape> */
    use SdkModel;

    /**
     * @var list<Job> $jobs
     */
    #[Required(list: Job::class)]
    public array $jobs;

    #[Required('has_next_page')]
    public bool $hasNextPage;

    /**
     * Cursor for the next page. Send it unchanged. Each next page arrives fast.
     */
    #[Required('next_cursor')]
    public string $nextCursor;

    /**
     * `new PaginatedJobs()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PaginatedJobs::with(jobs: ..., hasNextPage: ..., nextCursor: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PaginatedJobs)->withJobs(...)->withHasNextPage(...)->withNextCursor(...)
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
     * @param list<Job|array<string,mixed>> $jobs
     */
    public static function with(array $jobs, bool $hasNextPage, string $nextCursor): self
    {
        $self = new self;

        $self['jobs'] = $jobs;
        $self['hasNextPage'] = $hasNextPage;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * @param list<Job|array<string,mixed>> $jobs
     */
    public function withJobs(array $jobs): self
    {
        $self = clone $this;
        $self['jobs'] = $jobs;

        return $self;
    }

    public function withHasNextPage(bool $hasNextPage): self
    {
        $self = clone $this;
        $self['hasNextPage'] = $hasNextPage;

        return $self;
    }

    /**
     * Cursor for the next page. Send it unchanged. Each next page arrives fast.
     */
    public function withNextCursor(string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }
}
