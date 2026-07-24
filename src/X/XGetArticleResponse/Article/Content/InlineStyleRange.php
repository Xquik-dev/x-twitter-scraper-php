<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\XGetArticleResponse\Article\Content;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type InlineStyleRangeShape = array{
 *   length?: int|null, offset?: int|null, style?: string|null
 * }
 */
final class InlineStyleRange implements BaseModel
{
    /** @use SdkModel<InlineStyleRangeShape> */
    use SdkModel;

    #[Optional]
    public ?int $length;

    #[Optional]
    public ?int $offset;

    #[Optional]
    public ?string $style;

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
        ?int $length = null,
        ?int $offset = null,
        ?string $style = null
    ): self {
        $self = new self;

        null !== $length && $self['length'] = $length;
        null !== $offset && $self['offset'] = $offset;
        null !== $style && $self['style'] = $style;

        return $self;
    }

    public function withLength(int $length): self
    {
        $self = clone $this;
        $self['length'] = $length;

        return $self;
    }

    public function withOffset(int $offset): self
    {
        $self = clone $this;
        $self['offset'] = $offset;

        return $self;
    }

    public function withStyle(string $style): self
    {
        $self = clone $this;
        $self['style'] = $style;

        return $self;
    }
}
