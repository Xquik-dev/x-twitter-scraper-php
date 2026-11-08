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
 * @phpstan-type JobLocationShape = array{
 *   id: string,
 *   name: string,
 * }
 */
final class JobLocation implements BaseModel
{
    /** @use SdkModel<JobLocationShape> */
    use SdkModel;

    /**
     * Location ID, which the job search locationId takes.
     */
    #[Required]
    public string $id;

    /**
     * Place name with its region or country code.
     */
    #[Required]
    public string $name;

    /**
     * `new JobLocation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * JobLocation::with(id: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new JobLocation)->withId(...)->withName(...)
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
     */
    public static function with(string $id, string $name): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Location ID, which the job search locationId takes.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Place name with its region or country code.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
