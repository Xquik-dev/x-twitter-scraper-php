<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\SearchTweet2\SoftIntervention;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type UrlShape = array{
 *   url?: string|null,
 *   urlType?: string|null,
 * }
 */
final class Url implements BaseModel
{
    /** @use SdkModel<UrlShape> */
    use SdkModel;

    #[Optional]
    public ?string $url;

    #[Optional]
    public ?string $urlType;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $url = null, ?string $urlType = null): self
    {
        $self = new self;

        null !== $url && $self['url'] = $url;
        null !== $urlType && $self['urlType'] = $urlType;

        return $self;
    }

    public function withUrl(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    public function withUrlType(?string $urlType): self
    {
        $self = clone $this;
        $self['urlType'] = $urlType;

        return $self;
    }
}
