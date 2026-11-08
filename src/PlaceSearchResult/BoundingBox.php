<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\PlaceSearchResult;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type BoundingBoxShape = array{
 *   type: string,
 *   coordinates: list<mixed>,
 * }
 */
final class BoundingBox implements BaseModel
{
    /** @use SdkModel<BoundingBoxShape> */
    use SdkModel;

    /**
     * GeoJSON shape of the outline.
     */
    #[Required]
    public string $type;

    /**
     * Rings of points that draw the outline.
     *
     * @var list<mixed> $coordinates
     */
    #[Required(list: 'mixed')]
    public array $coordinates;

    /**
     * `new BoundingBox()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BoundingBox::with(type: ..., coordinates: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BoundingBox)->withType(...)->withCoordinates(...)
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
     * @param list<mixed> $coordinates
     */
    public static function with(string $type, array $coordinates): self
    {
        $self = new self;

        $self['type'] = $type;
        $self['coordinates'] = $coordinates;

        return $self;
    }

    /**
     * GeoJSON shape of the outline.
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Rings of points that draw the outline.
     *
     * @param list<mixed> $coordinates
     */
    public function withCoordinates(array $coordinates): self
    {
        $self = clone $this;
        $self['coordinates'] = $coordinates;

        return $self;
    }
}
