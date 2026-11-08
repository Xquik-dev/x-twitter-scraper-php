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
 * @phpstan-type TweetUrlEntityShape = array{
 *   displayUrl?: string|null,
 *   expandedUrl?: string|null,
 *   indices?: list<int>|null,
 *   url?: string|null,
 * }
 */
final class TweetUrlEntity implements BaseModel
{
    /** @use SdkModel<TweetUrlEntityShape> */
    use SdkModel;

    #[Optional('display_url')]
    public ?string $displayUrl;

    #[Optional('expanded_url')]
    public ?string $expandedUrl;

    /**
     * @var list<int>|null $indices
     */
    #[Optional(list: 'int')]
    public ?array $indices;

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
     *
     * @param list<int>|null $indices
     */
    public static function with(?string $displayUrl = null, ?string $expandedUrl = null, ?array $indices = null, ?string $url = null): self
    {
        $self = new self;

        null !== $displayUrl && $self['displayUrl'] = $displayUrl;
        null !== $expandedUrl && $self['expandedUrl'] = $expandedUrl;
        null !== $indices && $self['indices'] = $indices;
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

    /**
     * @param list<int>|null $indices
     */
    public function withIndices(?array $indices): self
    {
        $self = clone $this;
        $self['indices'] = $indices;

        return $self;
    }

    public function withUrl(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
