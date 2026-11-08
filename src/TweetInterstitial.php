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
use XTwitterScraper\TweetInterstitial\Text;

/**
 * @phpstan-type TweetInterstitialShape = array{
 *   displayType?: string|null,
 *   text?: Text|array<string,mixed>|null,
 * }
 */
final class TweetInterstitial implements BaseModel
{
    /** @use SdkModel<TweetInterstitialShape> */
    use SdkModel;

    /**
     * How x.com shows the notice. `NonCompliant` marks a post that broke X's rules.
     */
    #[Optional]
    public ?string $displayType;

    #[Optional]
    public ?Text $text;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Text|array<string,mixed>|null $text
     */
    public static function with(?string $displayType = null, Text|array|null $text = null): self
    {
        $self = new self;

        null !== $displayType && $self['displayType'] = $displayType;
        null !== $text && $self['text'] = $text;

        return $self;
    }

    /**
     * How x.com shows the notice. `NonCompliant` marks a post that broke X's rules.
     */
    public function withDisplayType(?string $displayType): self
    {
        $self = clone $this;
        $self['displayType'] = $displayType;

        return $self;
    }

    /**
     * @param Text|array<string,mixed>|null $text
     */
    public function withText(Text|array|null $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }
}
