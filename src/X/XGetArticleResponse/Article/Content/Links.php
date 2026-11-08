<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\XGetArticleResponse\Article\Content;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type LinksShape = array{
 *   offset?: int|null,
 *   length?: int|null,
 *   url?: string|null,
 * }
 */
final class Links implements BaseModel
{
    /** @use SdkModel<LinksShape> */
    use SdkModel;

    #[Optional]
    public ?int $offset;

    #[Optional]
    public ?int $length;

    #[Optional]
    public ?string $url;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $offset = null, ?int $length = null, ?string $url = null): self
    {
        $self = new self;

        null !== $offset && $self['offset'] = $offset;
        null !== $length && $self['length'] = $length;
        null !== $url && $self['url'] = $url;

        return $self;
    }

    public function withOffset(?int $offset): self
    {
        $self = clone $this;
        $self['offset'] = $offset;

        return $self;
    }

    public function withLength(?int $length): self
    {
        $self = clone $this;
        $self['length'] = $length;

        return $self;
    }

    public function withUrl(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
