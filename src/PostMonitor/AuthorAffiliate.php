<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\PostMonitor;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type AuthorAffiliateShape = array{
 *   badgeUrl: string,
 *   description: string,
 *   url?: string|null,
 * }
 */
final class AuthorAffiliate implements BaseModel
{
    /** @use SdkModel<AuthorAffiliateShape> */
    use SdkModel;

    /**
     * The organization's badge image.
     */
    #[Required]
    public string $badgeUrl;

    /**
     * The organization's name, as X shows it.
     */
    #[Required]
    public string $description;

    /**
     * The organization's X profile, when X links one.
     */
    #[Optional]
    public ?string $url;

    /**
     * `new AuthorAffiliate()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AuthorAffiliate::with(badgeUrl: ..., description: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AuthorAffiliate)->withBadgeUrl(...)->withDescription(...)
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
    public static function with(string $badgeUrl, string $description, ?string $url = null): self
    {
        $self = new self;

        $self['badgeUrl'] = $badgeUrl;
        $self['description'] = $description;

        null !== $url && $self['url'] = $url;

        return $self;
    }

    /**
     * The organization's badge image.
     */
    public function withBadgeUrl(string $badgeUrl): self
    {
        $self = clone $this;
        $self['badgeUrl'] = $badgeUrl;

        return $self;
    }

    /**
     * The organization's name, as X shows it.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * The organization's X profile, when X links one.
     */
    public function withUrl(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
