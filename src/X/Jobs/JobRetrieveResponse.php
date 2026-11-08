<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Jobs;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Job;

/**
 * @phpstan-type JobRetrieveResponseShape = array{
 *   job: Job|array<string,mixed>,
 * }
 */
final class JobRetrieveResponse implements BaseModel
{
    /** @use SdkModel<JobRetrieveResponseShape> */
    use SdkModel;

    /**
     * Public X job listing. A search returns the fields down to the salary, plus company & account. A lookup adds work type, seniority, function, team & descriptions. A field X leaves empty is left out.
     */
    #[Required]
    public Job $job;

    /**
     * `new JobRetrieveResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * JobRetrieveResponse::with(job: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new JobRetrieveResponse)->withJob(...)
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
     * @param Job|array<string,mixed> $job
     */
    public static function with(Job|array $job): self
    {
        $self = new self;

        $self['job'] = $job;

        return $self;
    }

    /**
     * Public X job listing. A search returns the fields down to the salary, plus company & account. A lookup adds work type, seniority, function, team & descriptions. A field X leaves empty is left out.
     *
     * @param Job|array<string,mixed> $job
     */
    public function withJob(Job|array $job): self
    {
        $self = clone $this;
        $self['job'] = $job;

        return $self;
    }
}
