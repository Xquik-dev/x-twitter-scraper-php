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

/**
 * @phpstan-type JobShape = array{
 *   id: string,
 *   url: string,
 *   title?: string|null,
 *   applyUrl?: string|null,
 *   location?: string|null,
 *   locationType?: string|null,
 *   employmentType?: string|null,
 *   seniorityLevel?: string|null,
 *   jobFunction?: string|null,
 *   team?: string|null,
 *   postedAt?: \DateTimeInterface|null,
 *   formattedSalary?: string|null,
 *   salaryMin?: float|null,
 *   salaryMax?: float|null,
 *   salaryCurrencyCode?: string|null,
 *   salaryInterval?: string|null,
 *   featured?: bool|null,
 *   shortDescription?: string|null,
 *   description?: string|null,
 *   descriptionMarkdown?: string|null,
 *   company?: JobCompany|array<string,mixed>|null,
 *   account?: JobAccount|array<string,mixed>|null,
 * }
 */
final class Job implements BaseModel
{
    /** @use SdkModel<JobShape> */
    use SdkModel;

    /**
     * Job ID.
     */
    #[Required]
    public string $id;

    /**
     * The job page on X.
     */
    #[Required]
    public string $url;

    /**
     * Job title.
     */
    #[Optional]
    public ?string $title;

    /**
     * Where applicants apply, off X.
     */
    #[Optional]
    public ?string $applyUrl;

    /**
     * Location as the employer wrote it.
     */
    #[Optional]
    public ?string $location;

    /**
     * Where the work happens (onsite, remote or hybrid).
     */
    #[Optional]
    public ?string $locationType;

    /**
     * Contract type (full_time, full_time_contract, part_time or contract_to_hire).
     */
    #[Optional]
    public ?string $employmentType;

    /**
     * Seniority (intern, entry_level, junior, mid_level, senior, lead, manager or executive).
     */
    #[Optional]
    public ?string $seniorityLevel;

    /**
     * Job function, such as software_engineering.
     */
    #[Optional]
    public ?string $jobFunction;

    /**
     * Team inside the company.
     */
    #[Optional]
    public ?string $team;

    /**
     * When the employer posted the job.
     */
    #[Optional]
    public ?\DateTimeInterface $postedAt;

    /**
     * Salary as X shows it.
     */
    #[Optional]
    public ?string $formattedSalary;

    /**
     * Lowest salary, in salaryCurrencyCode per salaryInterval.
     */
    #[Optional]
    public ?float $salaryMin;

    /**
     * Highest salary, in salaryCurrencyCode per salaryInterval.
     */
    #[Optional]
    public ?float $salaryMax;

    /**
     * ISO 4217 currency code of the salary.
     */
    #[Optional]
    public ?string $salaryCurrencyCode;

    /**
     * Pay period of the salary (annually or hourly).
     */
    #[Optional]
    public ?string $salaryInterval;

    /**
     * Whether X features the job.
     */
    #[Optional]
    public ?bool $featured;

    /**
     * Short summary of the job, as plain text.
     */
    #[Optional]
    public ?string $shortDescription;

    /**
     * Full description as plain text, 1 line per paragraph.
     */
    #[Optional]
    public ?string $description;

    /**
     * Full description as Markdown, with headings, lists, links, bold & italics.
     */
    #[Optional]
    public ?string $descriptionMarkdown;

    /**
     * The company profile of a job X imported from a job board.
     */
    #[Optional]
    public ?JobCompany $company;

    /**
     * The X account that posted a job. A job has none when X imported it from a job board or no longer shows the account.
     */
    #[Optional]
    public ?JobAccount $account;

    /**
     * `new Job()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Job::with(id: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Job)->withId(...)->withUrl(...)
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
     * @param JobCompany|array<string,mixed>|null $company
     * @param JobAccount|array<string,mixed>|null $account
     */
    public static function with(string $id, string $url, ?string $title = null, ?string $applyUrl = null, ?string $location = null, ?string $locationType = null, ?string $employmentType = null, ?string $seniorityLevel = null, ?string $jobFunction = null, ?string $team = null, ?\DateTimeInterface $postedAt = null, ?string $formattedSalary = null, ?float $salaryMin = null, ?float $salaryMax = null, ?string $salaryCurrencyCode = null, ?string $salaryInterval = null, ?bool $featured = null, ?string $shortDescription = null, ?string $description = null, ?string $descriptionMarkdown = null, JobCompany|array|null $company = null, JobAccount|array|null $account = null): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['url'] = $url;

        null !== $title && $self['title'] = $title;
        null !== $applyUrl && $self['applyUrl'] = $applyUrl;
        null !== $location && $self['location'] = $location;
        null !== $locationType && $self['locationType'] = $locationType;
        null !== $employmentType && $self['employmentType'] = $employmentType;
        null !== $seniorityLevel && $self['seniorityLevel'] = $seniorityLevel;
        null !== $jobFunction && $self['jobFunction'] = $jobFunction;
        null !== $team && $self['team'] = $team;
        null !== $postedAt && $self['postedAt'] = $postedAt;
        null !== $formattedSalary && $self['formattedSalary'] = $formattedSalary;
        null !== $salaryMin && $self['salaryMin'] = $salaryMin;
        null !== $salaryMax && $self['salaryMax'] = $salaryMax;
        null !== $salaryCurrencyCode && $self['salaryCurrencyCode'] = $salaryCurrencyCode;
        null !== $salaryInterval && $self['salaryInterval'] = $salaryInterval;
        null !== $featured && $self['featured'] = $featured;
        null !== $shortDescription && $self['shortDescription'] = $shortDescription;
        null !== $description && $self['description'] = $description;
        null !== $descriptionMarkdown && $self['descriptionMarkdown'] = $descriptionMarkdown;
        null !== $company && $self['company'] = $company;
        null !== $account && $self['account'] = $account;

        return $self;
    }

    /**
     * Job ID.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The job page on X.
     */
    public function withUrl(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Job title.
     */
    public function withTitle(?string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    /**
     * Where applicants apply, off X.
     */
    public function withApplyUrl(?string $applyUrl): self
    {
        $self = clone $this;
        $self['applyUrl'] = $applyUrl;

        return $self;
    }

    /**
     * Location as the employer wrote it.
     */
    public function withLocation(?string $location): self
    {
        $self = clone $this;
        $self['location'] = $location;

        return $self;
    }

    /**
     * Where the work happens (onsite, remote or hybrid).
     */
    public function withLocationType(?string $locationType): self
    {
        $self = clone $this;
        $self['locationType'] = $locationType;

        return $self;
    }

    /**
     * Contract type (full_time, full_time_contract, part_time or contract_to_hire).
     */
    public function withEmploymentType(?string $employmentType): self
    {
        $self = clone $this;
        $self['employmentType'] = $employmentType;

        return $self;
    }

    /**
     * Seniority (intern, entry_level, junior, mid_level, senior, lead, manager or executive).
     */
    public function withSeniorityLevel(?string $seniorityLevel): self
    {
        $self = clone $this;
        $self['seniorityLevel'] = $seniorityLevel;

        return $self;
    }

    /**
     * Job function, such as software_engineering.
     */
    public function withJobFunction(?string $jobFunction): self
    {
        $self = clone $this;
        $self['jobFunction'] = $jobFunction;

        return $self;
    }

    /**
     * Team inside the company.
     */
    public function withTeam(?string $team): self
    {
        $self = clone $this;
        $self['team'] = $team;

        return $self;
    }

    /**
     * When the employer posted the job.
     */
    public function withPostedAt(?\DateTimeInterface $postedAt): self
    {
        $self = clone $this;
        $self['postedAt'] = $postedAt;

        return $self;
    }

    /**
     * Salary as X shows it.
     */
    public function withFormattedSalary(?string $formattedSalary): self
    {
        $self = clone $this;
        $self['formattedSalary'] = $formattedSalary;

        return $self;
    }

    /**
     * Lowest salary, in salaryCurrencyCode per salaryInterval.
     */
    public function withSalaryMin(?float $salaryMin): self
    {
        $self = clone $this;
        $self['salaryMin'] = $salaryMin;

        return $self;
    }

    /**
     * Highest salary, in salaryCurrencyCode per salaryInterval.
     */
    public function withSalaryMax(?float $salaryMax): self
    {
        $self = clone $this;
        $self['salaryMax'] = $salaryMax;

        return $self;
    }

    /**
     * ISO 4217 currency code of the salary.
     */
    public function withSalaryCurrencyCode(?string $salaryCurrencyCode): self
    {
        $self = clone $this;
        $self['salaryCurrencyCode'] = $salaryCurrencyCode;

        return $self;
    }

    /**
     * Pay period of the salary (annually or hourly).
     */
    public function withSalaryInterval(?string $salaryInterval): self
    {
        $self = clone $this;
        $self['salaryInterval'] = $salaryInterval;

        return $self;
    }

    /**
     * Whether X features the job.
     */
    public function withFeatured(?bool $featured): self
    {
        $self = clone $this;
        $self['featured'] = $featured;

        return $self;
    }

    /**
     * Short summary of the job, as plain text.
     */
    public function withShortDescription(?string $shortDescription): self
    {
        $self = clone $this;
        $self['shortDescription'] = $shortDescription;

        return $self;
    }

    /**
     * Full description as plain text, 1 line per paragraph.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Full description as Markdown, with headings, lists, links, bold & italics.
     */
    public function withDescriptionMarkdown(?string $descriptionMarkdown): self
    {
        $self = clone $this;
        $self['descriptionMarkdown'] = $descriptionMarkdown;

        return $self;
    }

    /**
     * The company profile of a job X imported from a job board.
     *
     * @param JobCompany|array<string,mixed>|null $company
     */
    public function withCompany(JobCompany|array|null $company): self
    {
        $self = clone $this;
        $self['company'] = $company;

        return $self;
    }

    /**
     * The X account that posted a job. A job has none when X imported it from a job board or no longer shows the account.
     *
     * @param JobAccount|array<string,mixed>|null $account
     */
    public function withAccount(JobAccount|array|null $account): self
    {
        $self = clone $this;
        $self['account'] = $account;

        return $self;
    }
}
