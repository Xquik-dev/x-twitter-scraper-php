<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetAnalysisSummary\Monitor\ChangedRows;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ChangesShape = array{
 *   questionID: string,
 *   previous: string,
 *   current: string,
 * }
 */
final class Changes implements BaseModel
{
    /** @use SdkModel<ChangesShape> */
    use SdkModel;

    #[Required('questionId')]
    public string $questionID;

    #[Required]
    public string $previous;

    #[Required]
    public string $current;

    /**
     * `new Changes()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Changes::with(questionID: ..., previous: ..., current: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Changes)->withQuestionID(...)->withPrevious(...)->withCurrent(...)
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
    public static function with(string $questionID, string $previous, string $current): self
    {
        $self = new self;

        $self['questionID'] = $questionID;
        $self['previous'] = $previous;
        $self['current'] = $current;

        return $self;
    }

    public function withQuestionID(string $questionID): self
    {
        $self = clone $this;
        $self['questionID'] = $questionID;

        return $self;
    }

    public function withPrevious(string $previous): self
    {
        $self = clone $this;
        $self['previous'] = $previous;

        return $self;
    }

    public function withCurrent(string $current): self
    {
        $self = clone $this;
        $self['current'] = $current;

        return $self;
    }
}
