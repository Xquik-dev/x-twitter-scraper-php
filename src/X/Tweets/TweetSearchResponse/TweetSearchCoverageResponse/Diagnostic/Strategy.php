<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetSearchResponse\TweetSearchCoverageResponse\Diagnostic;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Tweets\TweetSearchResponse\TweetSearchCoverageResponse\Diagnostic\Strategy\QueryType;
use XTwitterScraper\X\Tweets\TweetSearchResponse\TweetSearchCoverageResponse\Diagnostic\Strategy\StopReason;
use XTwitterScraper\X\Tweets\TweetSearchResponse\TweetSearchCoverageResponse\Diagnostic\Strategy\Window;

/**
 * @phpstan-import-type WindowShape from \XTwitterScraper\X\Tweets\TweetSearchResponse\TweetSearchCoverageResponse\Diagnostic\Strategy\Window
 *
 * @phpstan-type StrategyShape = array{
 *   duplicateCount: int,
 *   pagesFetched: int,
 *   queryType: QueryType|value-of<QueryType>,
 *   stopReason: StopReason|value-of<StopReason>,
 *   strategy: int,
 *   uniqueAdded: int,
 *   window?: null|Window|WindowShape,
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

    /** @var value-of<QueryType> $queryType */
    #[Required(enum: QueryType::class)]
    public string $queryType;

    /** @var value-of<StopReason> $stopReason */
    #[Required(enum: StopReason::class)]
    public string $stopReason;

    #[Required]
    public int $strategy;

    #[Required]
    public int $uniqueAdded;

    /**
     * Non-overlapping time partition used by one strategy.
     */
    #[Optional]
    public ?Window $window;

    /**
     * `new Strategy()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Strategy::with(
     *   duplicateCount: ...,
     *   pagesFetched: ...,
     *   queryType: ...,
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
     *   ->withQueryType(...)
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
     * @param QueryType|value-of<QueryType> $queryType
     * @param StopReason|value-of<StopReason> $stopReason
     * @param Window|WindowShape|null $window
     */
    public static function with(
        int $duplicateCount,
        int $pagesFetched,
        QueryType|string $queryType,
        StopReason|string $stopReason,
        int $strategy,
        int $uniqueAdded,
        Window|array|null $window = null,
    ): self {
        $self = new self;

        $self['duplicateCount'] = $duplicateCount;
        $self['pagesFetched'] = $pagesFetched;
        $self['queryType'] = $queryType;
        $self['stopReason'] = $stopReason;
        $self['strategy'] = $strategy;
        $self['uniqueAdded'] = $uniqueAdded;

        null !== $window && $self['window'] = $window;

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
     * @param QueryType|value-of<QueryType> $queryType
     */
    public function withQueryType(QueryType|string $queryType): self
    {
        $self = clone $this;
        $self['queryType'] = $queryType;

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

    /**
     * Non-overlapping time partition used by one strategy.
     *
     * @param Window|WindowShape $window
     */
    public function withWindow(Window|array $window): self
    {
        $self = clone $this;
        $self['window'] = $window;

        return $self;
    }
}
