<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Users\UserGetFollowersResponse\UserListCoverageResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Users\UserGetFollowersResponse\UserListCoverageResponse\Diagnostic\Strategy;

/**
 * Coverage evidence across parallel relationship strategies.
 *
 * @phpstan-import-type StrategyShape from \XTwitterScraper\X\Users\UserGetFollowersResponse\UserListCoverageResponse\Diagnostic\Strategy
 *
 * @phpstan-type DiagnosticShape = array{
 *   complete: bool,
 *   cursorFailureCount: int,
 *   deadlineReached: bool,
 *   duplicateCount: int,
 *   failedStrategyCount: int,
 *   malformedCount: int,
 *   pagesFetched: int,
 *   responseTruncated: bool,
 *   resultLimitReached: bool,
 *   returnedUsers: int,
 *   stalledStrategyCount: int,
 *   strategies: list<Strategy|StrategyShape>,
 *   strategyCount: int,
 *   uniqueUsers: int,
 * }
 */
final class Diagnostic implements BaseModel
{
    /** @use SdkModel<DiagnosticShape> */
    use SdkModel;

    /**
     * True when every strategy exhausted its source.
     */
    #[Required]
    public bool $complete;

    #[Required]
    public int $cursorFailureCount;

    #[Required]
    public bool $deadlineReached;

    #[Required]
    public int $duplicateCount;

    #[Required]
    public int $failedStrategyCount;

    #[Required]
    public int $malformedCount;

    #[Required]
    public int $pagesFetched;

    /**
     * Whether credits or the requested limit reduced output.
     */
    #[Required]
    public bool $responseTruncated;

    #[Required]
    public bool $resultLimitReached;

    #[Required]
    public int $returnedUsers;

    #[Required]
    public int $stalledStrategyCount;

    /** @var list<Strategy> $strategies */
    #[Required(list: Strategy::class)]
    public array $strategies;

    #[Required]
    public int $strategyCount;

    #[Required]
    public int $uniqueUsers;

    /**
     * `new Diagnostic()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Diagnostic::with(
     *   complete: ...,
     *   cursorFailureCount: ...,
     *   deadlineReached: ...,
     *   duplicateCount: ...,
     *   failedStrategyCount: ...,
     *   malformedCount: ...,
     *   pagesFetched: ...,
     *   responseTruncated: ...,
     *   resultLimitReached: ...,
     *   returnedUsers: ...,
     *   stalledStrategyCount: ...,
     *   strategies: ...,
     *   strategyCount: ...,
     *   uniqueUsers: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Diagnostic)
     *   ->withComplete(...)
     *   ->withCursorFailureCount(...)
     *   ->withDeadlineReached(...)
     *   ->withDuplicateCount(...)
     *   ->withFailedStrategyCount(...)
     *   ->withMalformedCount(...)
     *   ->withPagesFetched(...)
     *   ->withResponseTruncated(...)
     *   ->withResultLimitReached(...)
     *   ->withReturnedUsers(...)
     *   ->withStalledStrategyCount(...)
     *   ->withStrategies(...)
     *   ->withStrategyCount(...)
     *   ->withUniqueUsers(...)
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
     * @param list<Strategy|StrategyShape> $strategies
     */
    public static function with(
        bool $complete,
        int $cursorFailureCount,
        bool $deadlineReached,
        int $duplicateCount,
        int $failedStrategyCount,
        int $malformedCount,
        int $pagesFetched,
        bool $responseTruncated,
        bool $resultLimitReached,
        int $returnedUsers,
        int $stalledStrategyCount,
        array $strategies,
        int $strategyCount,
        int $uniqueUsers,
    ): self {
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
        $self['returnedUsers'] = $returnedUsers;
        $self['stalledStrategyCount'] = $stalledStrategyCount;
        $self['strategies'] = $strategies;
        $self['strategyCount'] = $strategyCount;
        $self['uniqueUsers'] = $uniqueUsers;

        return $self;
    }

    /**
     * True when every strategy exhausted its source.
     */
    public function withComplete(bool $complete): self
    {
        $self = clone $this;
        $self['complete'] = $complete;

        return $self;
    }

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

    public function withDuplicateCount(int $duplicateCount): self
    {
        $self = clone $this;
        $self['duplicateCount'] = $duplicateCount;

        return $self;
    }

    public function withFailedStrategyCount(int $failedStrategyCount): self
    {
        $self = clone $this;
        $self['failedStrategyCount'] = $failedStrategyCount;

        return $self;
    }

    public function withMalformedCount(int $malformedCount): self
    {
        $self = clone $this;
        $self['malformedCount'] = $malformedCount;

        return $self;
    }

    public function withPagesFetched(int $pagesFetched): self
    {
        $self = clone $this;
        $self['pagesFetched'] = $pagesFetched;

        return $self;
    }

    /**
     * Whether credits or the requested limit reduced output.
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

    public function withReturnedUsers(int $returnedUsers): self
    {
        $self = clone $this;
        $self['returnedUsers'] = $returnedUsers;

        return $self;
    }

    public function withStalledStrategyCount(int $stalledStrategyCount): self
    {
        $self = clone $this;
        $self['stalledStrategyCount'] = $stalledStrategyCount;

        return $self;
    }

    /**
     * @param list<Strategy|StrategyShape> $strategies
     */
    public function withStrategies(array $strategies): self
    {
        $self = clone $this;
        $self['strategies'] = $strategies;

        return $self;
    }

    public function withStrategyCount(int $strategyCount): self
    {
        $self = clone $this;
        $self['strategyCount'] = $strategyCount;

        return $self;
    }

    public function withUniqueUsers(int $uniqueUsers): self
    {
        $self = clone $this;
        $self['uniqueUsers'] = $uniqueUsers;

        return $self;
    }
}
