<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ResolvedLinkShape = array{
 *   url: string,
 *   resolvedUrl?: string|null,
 * }
 */
final class ResolvedLink implements BaseModel
{
    /** @use SdkModel<ResolvedLinkShape> */
    use SdkModel;

    /**
     * The t.co link, as `https://t.co/<code>`.
     */
    #[Required]
    public string $url;

    /**
     * Target URL, as the link's author set it. Xquik does not check it. Absent for a link t.co does not have.
     */
    #[Optional]
    public ?string $resolvedUrl;

    /**
     * `new ResolvedLink()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ResolvedLink::with(url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ResolvedLink)->withUrl(...)
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
    public static function with(string $url, ?string $resolvedUrl = null): self
    {
        $self = new self;

        $self['url'] = $url;

        null !== $resolvedUrl && $self['resolvedUrl'] = $resolvedUrl;

        return $self;
    }

    /**
     * The t.co link, as `https://t.co/<code>`.
     */
    public function withUrl(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Target URL, as the link's author set it. Xquik does not check it. Absent for a link t.co does not have.
     */
    public function withResolvedUrl(?string $resolvedUrl): self
    {
        $self = clone $this;
        $self['resolvedUrl'] = $resolvedUrl;

        return $self;
    }
}
