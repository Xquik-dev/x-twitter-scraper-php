<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetAnalysisQuestion;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CriteriaShape = array{
 *   yes: string,
 *   no: string,
 * }
 */
final class Criteria implements BaseModel
{
    /** @use SdkModel<CriteriaShape> */
    use SdkModel;

    #[Required]
    public string $yes;

    #[Required]
    public string $no;

    /**
     * `new Criteria()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Criteria::with(yes: ..., no: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Criteria)->withYes(...)->withNo(...)
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
    public static function with(string $yes, string $no): self
    {
        $self = new self;

        $self['yes'] = $yes;
        $self['no'] = $no;

        return $self;
    }

    public function withYes(string $yes): self
    {
        $self = clone $this;
        $self['yes'] = $yes;

        return $self;
    }

    public function withNo(string $no): self
    {
        $self = clone $this;
        $self['no'] = $no;

        return $self;
    }
}
