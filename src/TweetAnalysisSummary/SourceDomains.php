<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetAnalysisSummary;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type SourceDomainsShape = array{
 *   domain: string,
 *   posts: int,
 * }
 */
final class SourceDomains implements BaseModel
{
    /** @use SdkModel<SourceDomainsShape> */
    use SdkModel;

    #[Required]
    public string $domain;

    #[Required]
    public int $posts;

    /**
     * `new SourceDomains()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SourceDomains::with(domain: ..., posts: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SourceDomains)->withDomain(...)->withPosts(...)
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
    public static function with(string $domain, int $posts): self
    {
        $self = new self;

        $self['domain'] = $domain;
        $self['posts'] = $posts;

        return $self;
    }

    public function withDomain(string $domain): self
    {
        $self = clone $this;
        $self['domain'] = $domain;

        return $self;
    }

    public function withPosts(int $posts): self
    {
        $self = clone $this;
        $self['posts'] = $posts;

        return $self;
    }
}
