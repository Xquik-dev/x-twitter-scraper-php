<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetAnalysisSummary;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\TweetAnalysisSummary\Monitor\ChangedRows;

/**
 * @phpstan-type MonitorShape = array{
 *   statuses: array<string,mixed>,
 *   changedRows: list<ChangedRows|array<string,mixed>>,
 * }
 */
final class Monitor implements BaseModel
{
    /** @use SdkModel<MonitorShape> */
    use SdkModel;

    /**
     * Posts per monitor status.
     *
     * @var array<string,mixed> $statuses
     */
    #[Required(map: 'mixed')]
    public array $statuses;

    /**
     * @var list<ChangedRows> $changedRows
     */
    #[Required(list: ChangedRows::class)]
    public array $changedRows;

    /**
     * `new Monitor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Monitor::with(statuses: ..., changedRows: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Monitor)->withStatuses(...)->withChangedRows(...)
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
     * @param array<string,mixed> $statuses
     * @param list<ChangedRows|array<string,mixed>> $changedRows
     */
    public static function with(array $statuses, array $changedRows): self
    {
        $self = new self;

        $self['statuses'] = $statuses;
        $self['changedRows'] = $changedRows;

        return $self;
    }

    /**
     * Posts per monitor status.
     *
     * @param array<string,mixed> $statuses
     */
    public function withStatuses(array $statuses): self
    {
        $self = clone $this;
        $self['statuses'] = $statuses;

        return $self;
    }

    /**
     * @param list<ChangedRows|array<string,mixed>> $changedRows
     */
    public function withChangedRows(array $changedRows): self
    {
        $self = clone $this;
        $self['changedRows'] = $changedRows;

        return $self;
    }
}
