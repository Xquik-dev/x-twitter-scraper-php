<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Spaces;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Space;

/**
 * @phpstan-type SpaceRetrieveResponseShape = array{
 *   space: Space|array<string,mixed>,
 * }
 */
final class SpaceRetrieveResponse implements BaseModel
{
    /** @use SdkModel<SpaceRetrieveResponseShape> */
    use SdkModel;

    /**
     * X Space.
     */
    #[Required]
    public Space $space;

    /**
     * `new SpaceRetrieveResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SpaceRetrieveResponse::with(space: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SpaceRetrieveResponse)->withSpace(...)
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
     * @param Space|array<string,mixed> $space
     */
    public static function with(Space|array $space): self
    {
        $self = new self;

        $self['space'] = $space;

        return $self;
    }

    /**
     * X Space.
     *
     * @param Space|array<string,mixed> $space
     */
    public function withSpace(Space|array $space): self
    {
        $self = clone $this;
        $self['space'] = $space;

        return $self;
    }
}
