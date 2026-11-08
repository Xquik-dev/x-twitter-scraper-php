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
 * @phpstan-type UserListCoverageStrategyShape = array{
 *   duplicateCount: int,
 *   pagesFetched: int,
 *   stopReason: CoverageStopReason|value-of<CoverageStopReason>,
 *   strategy: int,
 *   uniqueAdded: int,
 * }
 */
final class UserListCoverageStrategy implements BaseModel
{
    /** @use SdkModel<UserListCoverageStrategyShape> */
    use SdkModel;

    /**
     * Whole number from 0.
     */
    #[Required]
    public int $duplicateCount;

    /**
     * Whole number from 0.
     */
    #[Required]
    public int $pagesFetched;

    /**
     * Why the read stopped.
     *
     * @var value-of<CoverageStopReason> $stopReason
     */
    #[Required(enum: CoverageStopReason::class)]
    public string $stopReason;

    #[Required]
    public int $strategy;

    /**
     * Whole number from 0.
     */
    #[Required]
    public int $uniqueAdded;

    /**
     * `new UserListCoverageStrategy()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserListCoverageStrategy::with(duplicateCount: ..., pagesFetched: ..., stopReason: ..., strategy: ..., uniqueAdded: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserListCoverageStrategy)->withDuplicateCount(...)->withPagesFetched(...)->withStopReason(...)->withStrategy(...)->withUniqueAdded(...)
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
     * @param CoverageStopReason|value-of<CoverageStopReason> $stopReason
     */
    public static function with(int $duplicateCount, int $pagesFetched, CoverageStopReason|string $stopReason, int $strategy, int $uniqueAdded): self
    {
        $self = new self;

        $self['duplicateCount'] = $duplicateCount;
        $self['pagesFetched'] = $pagesFetched;
        $self['stopReason'] = $stopReason;
        $self['strategy'] = $strategy;
        $self['uniqueAdded'] = $uniqueAdded;

        return $self;
    }

    /**
     * Whole number from 0.
     */
    public function withDuplicateCount(int $duplicateCount): self
    {
        $self = clone $this;
        $self['duplicateCount'] = $duplicateCount;

        return $self;
    }

    /**
     * Whole number from 0.
     */
    public function withPagesFetched(int $pagesFetched): self
    {
        $self = clone $this;
        $self['pagesFetched'] = $pagesFetched;

        return $self;
    }

    /**
     * Why the read stopped.
     *
     * @param CoverageStopReason|value-of<CoverageStopReason> $stopReason
     */
    public function withStopReason(CoverageStopReason|string $stopReason): self
    {
        $self = clone $this;
        $self['stopReason'] = $stopReason;

        return $self;
    }

    public function withStrategy(int $strategy): self
    {
        $self = clone $this;
        $self['strategy'] = $strategy;

        return $self;
    }

    /**
     * Whole number from 0.
     */
    public function withUniqueAdded(int $uniqueAdded): self
    {
        $self = clone $this;
        $self['uniqueAdded'] = $uniqueAdded;

        return $self;
    }
}
