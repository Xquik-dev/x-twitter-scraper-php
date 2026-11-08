<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\CommunityNoteEntity\Ref;
use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CommunityNoteEntityShape = array{
 *   fromIndex?: int|null,
 *   toIndex?: int|null,
 *   ref?: Ref|array<string,mixed>|null,
 * }
 */
final class CommunityNoteEntity implements BaseModel
{
    /** @use SdkModel<CommunityNoteEntityShape> */
    use SdkModel;

    /**
     * Where it starts in the text.
     */
    #[Optional]
    public ?int $fromIndex;

    /**
     * Where it ends in the text.
     */
    #[Optional]
    public ?int $toIndex;

    /**
     * What it points at.
     */
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
     * Where it starts in the text.
     */
    public function withFromIndex(?int $fromIndex): self
    {
        $self = clone $this;
        $self['fromIndex'] = $fromIndex;

        return $self;
    }

    /**
     * Where it ends in the text.
     */
    public function withToIndex(?int $toIndex): self
    {
        $self = clone $this;
        $self['toIndex'] = $toIndex;

        return $self;
    }

    /**
     * What it points at.
     *
     * @param Ref|array<string,mixed>|null $ref
     */
    public function withRef(Ref|array|null $ref): self
    {
        $self = clone $this;
        $self['ref'] = $ref;

        return $self;
    }
}
