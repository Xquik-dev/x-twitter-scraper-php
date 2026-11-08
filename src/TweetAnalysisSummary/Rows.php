<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetAnalysisSummary;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type RowsShape = array{
 *   analyzed: int,
 *   failed: int,
 *   skipped: int,
 * }
 */
final class Rows implements BaseModel
{
    /** @use SdkModel<RowsShape> */
    use SdkModel;

    #[Required]
    public int $analyzed;

    #[Required]
    public int $failed;

    #[Required]
    public int $skipped;

    /**
     * `new Rows()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Rows::with(analyzed: ..., failed: ..., skipped: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Rows)->withAnalyzed(...)->withFailed(...)->withSkipped(...)
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
    public static function with(int $analyzed, int $failed, int $skipped): self
    {
        $self = new self;

        $self['analyzed'] = $analyzed;
        $self['failed'] = $failed;
        $self['skipped'] = $skipped;

        return $self;
    }

    public function withAnalyzed(int $analyzed): self
    {
        $self = clone $this;
        $self['analyzed'] = $analyzed;

        return $self;
    }

    public function withFailed(int $failed): self
    {
        $self = clone $this;
        $self['failed'] = $failed;

        return $self;
    }

    public function withSkipped(int $skipped): self
    {
        $self = clone $this;
        $self['skipped'] = $skipped;

        return $self;
    }
}
