<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\FollowerAudit;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\FollowerAudit\Quality\Grade;

/**
 * @phpstan-type QualityShape = array{
 *   grade: Grade|value-of<Grade>,
 *   score: int,
 * }
 */
final class Quality implements BaseModel
{
    /** @use SdkModel<QualityShape> */
    use SdkModel;

    /**
     * @var value-of<Grade> $grade
     */
    #[Required(enum: Grade::class)]
    public string $grade;

    #[Required]
    public int $score;

    /**
     * `new Quality()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Quality::with(grade: ..., score: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Quality)->withGrade(...)->withScore(...)
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
     * @param Grade|value-of<Grade> $grade
     */
    public static function with(Grade|string $grade, int $score): self
    {
        $self = new self;

        $self['grade'] = $grade;
        $self['score'] = $score;

        return $self;
    }

    /**
     * @param Grade|value-of<Grade> $grade
     */
    public function withGrade(Grade|string $grade): self
    {
        $self = clone $this;
        $self['grade'] = $grade;

        return $self;
    }

    public function withScore(int $score): self
    {
        $self = clone $this;
        $self['score'] = $score;

        return $self;
    }
}
