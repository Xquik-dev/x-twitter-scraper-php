<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetAnalysisSummary\Monitor;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\TweetAnalysisSummary\Monitor\ChangedRows\Changes;

/**
 * @phpstan-type ChangedRowsShape = array{
 *   tweetID: string,
 *   changes: list<Changes|array<string,mixed>>,
 * }
 */
final class ChangedRows implements BaseModel
{
    /** @use SdkModel<ChangedRowsShape> */
    use SdkModel;

    #[Required('tweetId')]
    public string $tweetID;

    /**
     * @var list<Changes> $changes
     */
    #[Required(list: Changes::class)]
    public array $changes;

    /**
     * `new ChangedRows()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChangedRows::with(tweetID: ..., changes: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChangedRows)->withTweetID(...)->withChanges(...)
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
     * @param list<Changes|array<string,mixed>> $changes
     */
    public static function with(string $tweetID, array $changes): self
    {
        $self = new self;

        $self['tweetID'] = $tweetID;
        $self['changes'] = $changes;

        return $self;
    }

    public function withTweetID(string $tweetID): self
    {
        $self = clone $this;
        $self['tweetID'] = $tweetID;

        return $self;
    }

    /**
     * @param list<Changes|array<string,mixed>> $changes
     */
    public function withChanges(array $changes): self
    {
        $self = clone $this;
        $self['changes'] = $changes;

        return $self;
    }
}
