<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ImageFilterSummary;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * A post the filter couldn't check, with the reason.
 *
 * @phpstan-type UncheckedShape = array{
 *   id: string,
 *   reason: string,
 * }
 */
final class Unchecked implements BaseModel
{
    /** @use SdkModel<UncheckedShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $reason;

    /**
     * `new Unchecked()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Unchecked::with(id: ..., reason: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Unchecked)
     *   ->withId(...)
     *   ->withReason(...)
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
    public static function with(
        string $id,
        string $reason,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['reason'] = $reason;

        return $self;
    }

    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withReason(string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }
}
