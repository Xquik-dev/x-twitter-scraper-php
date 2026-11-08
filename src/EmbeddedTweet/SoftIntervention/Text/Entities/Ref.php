<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\EmbeddedTweet\SoftIntervention\Text\Entities;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type RefShape = array{
 *   type?: string|null,
 *   url?: string|null,
 *   urlType?: string|null,
 *   text?: string|null,
 *   screenName?: string|null,
 * }
 */
final class Ref implements BaseModel
{
    /** @use SdkModel<RefShape> */
    use SdkModel;

    #[Optional]
    public ?string $type;

    #[Optional]
    public ?string $url;

    #[Optional]
    public ?string $urlType;

    #[Optional]
    public ?string $text;

    #[Optional]
    public ?string $screenName;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $type = null, ?string $url = null, ?string $urlType = null, ?string $text = null, ?string $screenName = null): self
    {
        $self = new self;

        null !== $type && $self['type'] = $type;
        null !== $url && $self['url'] = $url;
        null !== $urlType && $self['urlType'] = $urlType;
        null !== $text && $self['text'] = $text;
        null !== $screenName && $self['screenName'] = $screenName;

        return $self;
    }

    public function withType(?string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

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

    public function withText(?string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    public function withScreenName(?string $screenName): self
    {
        $self = clone $this;
        $self['screenName'] = $screenName;

        return $self;
    }
}
