<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\EmbeddedTweet;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type QuotedTweetPermalinkShape = array{
 *   displayUrl?: string|null,
 *   expandedUrl?: string|null,
 *   url?: string|null,
 * }
 */
final class QuotedTweetPermalink implements BaseModel
{
    /** @use SdkModel<QuotedTweetPermalinkShape> */
    use SdkModel;

    #[Optional]
    public ?string $displayUrl;

    #[Optional]
    public ?string $expandedUrl;

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
    public static function with(?string $displayUrl = null, ?string $expandedUrl = null, ?string $url = null): self
    {
        $self = new self;

        null !== $displayUrl && $self['displayUrl'] = $displayUrl;
        null !== $expandedUrl && $self['expandedUrl'] = $expandedUrl;
        null !== $url && $self['url'] = $url;

        return $self;
    }

    public function withDisplayUrl(?string $displayUrl): self
    {
        $self = clone $this;
        $self['displayUrl'] = $displayUrl;

        return $self;
    }

    public function withExpandedUrl(?string $expandedUrl): self
    {
        $self = clone $this;
        $self['expandedUrl'] = $expandedUrl;

        return $self;
    }

    public function withUrl(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
