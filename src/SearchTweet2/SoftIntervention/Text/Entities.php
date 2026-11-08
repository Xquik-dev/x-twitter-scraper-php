<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\SearchTweet2\SoftIntervention\Text;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\SearchTweet2\SoftIntervention\Text\Entities\Ref;

/**
 * @phpstan-type EntitiesShape = array{
 *   fromIndex?: int|null,
 *   toIndex?: int|null,
 *   ref?: Ref|array<string,mixed>|null,
 * }
 */
final class Entities implements BaseModel
{
    /** @use SdkModel<EntitiesShape> */
    use SdkModel;

    /**
     * Whole number from 0.
     */
    #[Optional]
    public ?int $fromIndex;

    /**
     * Whole number from 0.
     */
    #[Optional]
    public ?int $toIndex;

    #[Optional]
    public ?Ref $ref;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Ref|array<string,mixed>|null $ref
     */
    public static function with(?int $fromIndex = null, ?int $toIndex = null, Ref|array|null $ref = null): self
    {
        $self = new self;

        null !== $fromIndex && $self['fromIndex'] = $fromIndex;
        null !== $toIndex && $self['toIndex'] = $toIndex;
        null !== $ref && $self['ref'] = $ref;

        return $self;
    }

    /**
     * Whole number from 0.
     */
    public function withFromIndex(?int $fromIndex): self
    {
        $self = clone $this;
        $self['fromIndex'] = $fromIndex;

        return $self;
    }

    /**
     * Whole number from 0.
     */
    public function withToIndex(?int $toIndex): self
    {
        $self = clone $this;
        $self['toIndex'] = $toIndex;

        return $self;
    }

    /**
     * @param Ref|array<string,mixed>|null $ref
     */
    public function withRef(Ref|array|null $ref): self
    {
        $self = clone $this;
        $self['ref'] = $ref;

        return $self;
    }
}
