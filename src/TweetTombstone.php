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
use XTwitterScraper\TweetTombstone\Text;

/**
 * @phpstan-type TweetTombstoneShape = array{
 *   type?: string|null,
 *   text?: Text|array<string,mixed>|null,
 * }
 */
final class TweetTombstone implements BaseModel
{
    /** @use SdkModel<TweetTombstoneShape> */
    use SdkModel;

    /**
     * Visibility notice type.
     */
    #[Optional]
    public ?string $type;

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
    public static function with(?string $type = null, Text|array|null $text = null): self
    {
        $self = new self;

        null !== $type && $self['type'] = $type;
        null !== $text && $self['text'] = $text;

        return $self;
    }

    /**
     * Visibility notice type.
     */
    public function withType(?string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

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
