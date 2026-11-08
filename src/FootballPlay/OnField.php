<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\FootballPlay;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type OnFieldShape = array{
 *   calledBack: bool|null,
 *   penaltyOnField: bool|null,
 *   timeout: bool|null,
 *   underReview: bool|null,
 * }
 */
final class OnField implements BaseModel
{
    /** @use SdkModel<OnFieldShape> */
    use SdkModel;

    /**
     * Whether a penalty called the play back.
     */
    #[Required]
    public ?bool $calledBack;

    /**
     * Whether a flag was thrown.
     */
    #[Required]
    public ?bool $penaltyOnField;

    /**
     * Whether a timeout followed the play.
     */
    #[Required]
    public ?bool $timeout;

    /**
     * Whether officials were reviewing the play.
     */
    #[Required]
    public ?bool $underReview;

    /**
     * `new OnField()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * OnField::with(calledBack: ..., penaltyOnField: ..., timeout: ..., underReview: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new OnField)->withCalledBack(...)->withPenaltyOnField(...)->withTimeout(...)->withUnderReview(...)
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
    public static function with(?bool $calledBack, ?bool $penaltyOnField, ?bool $timeout, ?bool $underReview): self
    {
        $self = new self;

        $self['calledBack'] = $calledBack;
        $self['penaltyOnField'] = $penaltyOnField;
        $self['timeout'] = $timeout;
        $self['underReview'] = $underReview;

        return $self;
    }

    /**
     * Whether a penalty called the play back.
     */
    public function withCalledBack(?bool $calledBack): self
    {
        $self = clone $this;
        $self['calledBack'] = $calledBack;

        return $self;
    }

    /**
     * Whether a flag was thrown.
     */
    public function withPenaltyOnField(?bool $penaltyOnField): self
    {
        $self = clone $this;
        $self['penaltyOnField'] = $penaltyOnField;

        return $self;
    }

    /**
     * Whether a timeout followed the play.
     */
    public function withTimeout(?bool $timeout): self
    {
        $self = clone $this;
        $self['timeout'] = $timeout;

        return $self;
    }

    /**
     * Whether officials were reviewing the play.
     */
    public function withUnderReview(?bool $underReview): self
    {
        $self = clone $this;
        $self['underReview'] = $underReview;

        return $self;
    }
}
