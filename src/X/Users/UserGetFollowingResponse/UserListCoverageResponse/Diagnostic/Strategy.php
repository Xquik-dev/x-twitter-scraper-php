<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Users\UserGetFollowingResponse\UserListCoverageResponse\Diagnostic;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Users\UserGetFollowingResponse\UserListCoverageResponse\Diagnostic\Strategy\StopReason;

/**
 * @phpstan-type StrategyShape = array{
 *   duplicateCount: int,
 *   pagesFetched: int,
 *   stopReason: StopReason|value-of<StopReason>,
 *   strategy: int,
 *   uniqueAdded: int,
 * }
 */
final class Strategy implements BaseModel
{
    /** @use SdkModel<StrategyShape> */
    use SdkModel;

    #[Required]
    public int $duplicateCount;

    #[Required]
    public int $pagesFetched;

    /** @var value-of<StopReason> $stopReason */
    #[Required(enum: StopReason::class)]
    public string $stopReason;

    #[Required]
    public int $strategy;

    #[Required]
    public int $uniqueAdded;

    /**
     * `new Strategy()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Strategy::with(
     *   duplicateCount: ...,
     *   pagesFetched: ...,
     *   stopReason: ...,
     *   strategy: ...,
     *   uniqueAdded: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Strategy)
     *   ->withDuplicateCount(...)
     *   ->withPagesFetched(...)
     *   ->withStopReason(...)
     *   ->withStrategy(...)
     *   ->withUniqueAdded(...)
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
     * @param StopReason|value-of<StopReason> $stopReason
     */
    public static function with(
        int $duplicateCount,
        int $pagesFetched,
        StopReason|string $stopReason,
        int $strategy,
        int $uniqueAdded,
    ): self {
        $self = new self;

        $self['duplicateCount'] = $duplicateCount;
        $self['pagesFetched'] = $pagesFetched;
        $self['stopReason'] = $stopReason;
        $self['strategy'] = $strategy;
        $self['uniqueAdded'] = $uniqueAdded;

        return $self;
    }

    public function withDuplicateCount(int $duplicateCount): self
    {
        $self = clone $this;
        $self['duplicateCount'] = $duplicateCount;

        return $self;
    }

    public function withPagesFetched(int $pagesFetched): self
    {
        $self = clone $this;
        $self['pagesFetched'] = $pagesFetched;

        return $self;
    }

    /**
     * @param StopReason|value-of<StopReason> $stopReason
     */
    public function withStopReason(StopReason|string $stopReason): self
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

    public function withUniqueAdded(int $uniqueAdded): self
    {
        $self = clone $this;
        $self['uniqueAdded'] = $uniqueAdded;

        return $self;
    }
}
