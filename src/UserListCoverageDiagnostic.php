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
 * @phpstan-type UserListCoverageDiagnosticShape = array{
 *   complete: bool,
 *   cursorFailureCount: int,
 *   deadlineReached: bool,
 *   duplicateCount: int,
 *   failedStrategyCount: int,
 *   malformedCount: int,
 *   pagesFetched: int,
 *   responseTruncated: bool,
 *   resultLimitReached: bool,
 *   stalledStrategyCount: int,
 *   strategyCount: int,
 *   returnedUsers: int,
 *   strategies: list<UserListCoverageStrategy|array<string,mixed>>,
 *   uniqueUsers: int,
 * }
 */
final class UserListCoverageDiagnostic implements BaseModel
{
    /** @use SdkModel<UserListCoverageDiagnosticShape> */
    use SdkModel;

    /**
     * True when the result covers the whole query & range.
     */
    #[Required]
    public bool $complete;

    /**
     * Whole number from 0.
     */
    #[Required]
    public int $cursorFailureCount;

    #[Required]
    public bool $deadlineReached;

    /**
     * Whole number from 0.
     */
    #[Required]
    public int $duplicateCount;

    /**
     * Whole number from 0.
     */
    #[Required]
    public int $failedStrategyCount;

    /**
     * Whole number from 0.
     */
    #[Required]
    public int $malformedCount;

    /**
     * Whole number from 0.
     */
    #[Required]
    public int $pagesFetched;

    /**
     * True when credits or the requested limit reduce output.
     */
    #[Required]
    public bool $responseTruncated;

    #[Required]
    public bool $resultLimitReached;

    /**
     * Whole number from 0.
     */
    #[Required]
    public int $stalledStrategyCount;

    #[Required]
    public int $strategyCount;

    #[Required]
    public int $returnedUsers;

    /**
     * @var list<UserListCoverageStrategy> $strategies
     */
    #[Required(list: UserListCoverageStrategy::class)]
    public array $strategies;

    #[Required]
    public int $uniqueUsers;

    /**
     * `new UserListCoverageDiagnostic()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserListCoverageDiagnostic::with(complete: ..., cursorFailureCount: ..., deadlineReached: ..., duplicateCount: ..., failedStrategyCount: ..., malformedCount: ..., pagesFetched: ..., responseTruncated: ..., resultLimitReached: ..., stalledStrategyCount: ..., strategyCount: ..., returnedUsers: ..., strategies: ..., uniqueUsers: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserListCoverageDiagnostic)->withComplete(...)->withCursorFailureCount(...)->withDeadlineReached(...)->withDuplicateCount(...)->withFailedStrategyCount(...)->withMalformedCount(...)->withPagesFetched(...)->withResponseTruncated(...)->withResultLimitReached(...)->withStalledStrategyCount(...)->withStrategyCount(...)->withReturnedUsers(...)->withStrategies(...)->withUniqueUsers(...)
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
     * @param list<UserListCoverageStrategy|array<string,mixed>> $strategies
     */
    public static function with(bool $complete, int $cursorFailureCount, bool $deadlineReached, int $duplicateCount, int $failedStrategyCount, int $malformedCount, int $pagesFetched, bool $responseTruncated, bool $resultLimitReached, int $stalledStrategyCount, int $strategyCount, int $returnedUsers, array $strategies, int $uniqueUsers): self
    {
        $self = new self;

        $self['complete'] = $complete;
        $self['cursorFailureCount'] = $cursorFailureCount;
        $self['deadlineReached'] = $deadlineReached;
        $self['duplicateCount'] = $duplicateCount;
        $self['failedStrategyCount'] = $failedStrategyCount;
        $self['malformedCount'] = $malformedCount;
        $self['pagesFetched'] = $pagesFetched;
        $self['responseTruncated'] = $responseTruncated;
        $self['resultLimitReached'] = $resultLimitReached;
        $self['stalledStrategyCount'] = $stalledStrategyCount;
        $self['strategyCount'] = $strategyCount;
        $self['returnedUsers'] = $returnedUsers;
        $self['strategies'] = $strategies;
        $self['uniqueUsers'] = $uniqueUsers;

        return $self;
    }

    /**
     * True when the result covers the whole query & range.
     */
    public function withComplete(bool $complete): self
    {
        $self = clone $this;
        $self['complete'] = $complete;

        return $self;
    }

    /**
     * Whole number from 0.
     */
    public function withCursorFailureCount(int $cursorFailureCount): self
    {
        $self = clone $this;
        $self['cursorFailureCount'] = $cursorFailureCount;

        return $self;
    }

    public function withDeadlineReached(bool $deadlineReached): self
    {
        $self = clone $this;
        $self['deadlineReached'] = $deadlineReached;

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
    public function withFailedStrategyCount(int $failedStrategyCount): self
    {
        $self = clone $this;
        $self['failedStrategyCount'] = $failedStrategyCount;

        return $self;
    }

    /**
     * Whole number from 0.
     */
    public function withMalformedCount(int $malformedCount): self
    {
        $self = clone $this;
        $self['malformedCount'] = $malformedCount;

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
     * True when credits or the requested limit reduce output.
     */
    public function withResponseTruncated(bool $responseTruncated): self
    {
        $self = clone $this;
        $self['responseTruncated'] = $responseTruncated;

        return $self;
    }

    public function withResultLimitReached(bool $resultLimitReached): self
    {
        $self = clone $this;
        $self['resultLimitReached'] = $resultLimitReached;

        return $self;
    }

    /**
     * Whole number from 0.
     */
    public function withStalledStrategyCount(int $stalledStrategyCount): self
    {
        $self = clone $this;
        $self['stalledStrategyCount'] = $stalledStrategyCount;

        return $self;
    }

    public function withStrategyCount(int $strategyCount): self
    {
        $self = clone $this;
        $self['strategyCount'] = $strategyCount;

        return $self;
    }

    public function withReturnedUsers(int $returnedUsers): self
    {
        $self = clone $this;
        $self['returnedUsers'] = $returnedUsers;

        return $self;
    }

    /**
     * @param list<UserListCoverageStrategy|array<string,mixed>> $strategies
     */
    public function withStrategies(array $strategies): self
    {
        $self = clone $this;
        $self['strategies'] = $strategies;

        return $self;
    }

    public function withUniqueUsers(int $uniqueUsers): self
    {
        $self = clone $this;
        $self['uniqueUsers'] = $uniqueUsers;

        return $self;
    }
}
