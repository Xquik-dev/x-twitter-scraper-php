<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ProfileContactInfo;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\ProfileContactInfo\Links\Source;

/**
 * @phpstan-type LinksShape = array{
 *   url: string,
 *   network: string,
 *   source: Source|value-of<Source>,
 * }
 */
final class Links implements BaseModel
{
    /** @use SdkModel<LinksShape> */
    use SdkModel;

    /**
     * The link, as X expands it.
     */
    #[Required]
    public string $url;

    /**
     * Site the link belongs to, such as `linkedin`, `github` or `telegram`. Any other site is `website`.
     */
    #[Required]
    public string $network;

    /**
     * `url` for the website field, `bio` for a bio link.
     *
     * @var value-of<Source> $source
     */
    #[Required(enum: Source::class)]
    public string $source;

    /**
     * `new Links()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Links::with(url: ..., network: ..., source: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Links)->withUrl(...)->withNetwork(...)->withSource(...)
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
     * @param Source|value-of<Source> $source
     */
    public static function with(string $url, string $network, Source|string $source): self
    {
        $self = new self;

        $self['url'] = $url;
        $self['network'] = $network;
        $self['source'] = $source;

        return $self;
    }

    /**
     * The link, as X expands it.
     */
    public function withUrl(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Site the link belongs to, such as `linkedin`, `github` or `telegram`. Any other site is `website`.
     */
    public function withNetwork(string $network): self
    {
        $self = clone $this;
        $self['network'] = $network;

        return $self;
    }

    /**
     * `url` for the website field, `bio` for a bio link.
     *
     * @param Source|value-of<Source> $source
     */
    public function withSource(Source|string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }
}
