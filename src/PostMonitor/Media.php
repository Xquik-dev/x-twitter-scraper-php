<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\PostMonitor;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\PostMonitor\Media\Kind;

/**
 * @phpstan-type MediaShape = array{
 *   kind: Kind|value-of<Kind>,
 *   url: string,
 * }
 */
final class Media implements BaseModel
{
    /** @use SdkModel<MediaShape> */
    use SdkModel;

    /**
     * @var value-of<Kind> $kind
     */
    #[Required(enum: Kind::class)]
    public string $kind;

    /**
     * The image URL. For a video or GIF, its preview image.
     */
    #[Required]
    public string $url;

    /**
     * `new Media()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Media::with(kind: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Media)->withKind(...)->withUrl(...)
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
     * @param Kind|value-of<Kind> $kind
     */
    public static function with(Kind|string $kind, string $url): self
    {
        $self = new self;

        $self['kind'] = $kind;
        $self['url'] = $url;

        return $self;
    }

    /**
     * @param Kind|value-of<Kind> $kind
     */
    public function withKind(Kind|string $kind): self
    {
        $self = clone $this;
        $self['kind'] = $kind;

        return $self;
    }

    /**
     * The image URL. For a video or GIF, its preview image.
     */
    public function withUrl(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
