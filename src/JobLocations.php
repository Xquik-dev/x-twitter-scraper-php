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
 * @phpstan-type JobLocationsShape = array{
 *   locations: list<JobLocation|array<string,mixed>>,
 *   count: int,
 * }
 */
final class JobLocations implements BaseModel
{
    /** @use SdkModel<JobLocationsShape> */
    use SdkModel;

    /**
     * Matching places, best match first.
     *
     * @var list<JobLocation> $locations
     */
    #[Required(list: JobLocation::class)]
    public array $locations;

    /**
     * Places returned, each charged 1 credit.
     */
    #[Required]
    public int $count;

    /**
     * `new JobLocations()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * JobLocations::with(locations: ..., count: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new JobLocations)->withLocations(...)->withCount(...)
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
     * @param list<JobLocation|array<string,mixed>> $locations
     */
    public static function with(array $locations, int $count): self
    {
        $self = new self;

        $self['locations'] = $locations;
        $self['count'] = $count;

        return $self;
    }

    /**
     * Matching places, best match first.
     *
     * @param list<JobLocation|array<string,mixed>> $locations
     */
    public function withLocations(array $locations): self
    {
        $self = clone $this;
        $self['locations'] = $locations;

        return $self;
    }

    /**
     * Places returned, each charged 1 credit.
     */
    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }
}
