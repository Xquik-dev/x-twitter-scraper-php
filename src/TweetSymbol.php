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
 * @phpstan-type TweetSymbolShape = array{
 *   indices?: list<int>|null,
 *   seconds?: float|null,
 *   text?: string|null,
 *   tag?: TweetSmartTag|array<string,mixed>|null,
 * }
 */
final class TweetSymbol implements BaseModel
{
    /** @use SdkModel<TweetSymbolShape> */
    use SdkModel;

    /**
     * @var list<int>|null $indices
     */
    #[Optional(list: 'int')]
    public ?array $indices;

    #[Optional]
    public ?float $seconds;

    #[Optional]
    public ?string $text;

    /**
     * X's SmartTag for a cashtag, smarttag or hashtag.
     */
    #[Optional]
    public ?TweetSmartTag $tag;

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
     * @param TweetSmartTag|array<string,mixed>|null $tag
     */
    public static function with(?array $indices = null, ?float $seconds = null, ?string $text = null, TweetSmartTag|array|null $tag = null): self
    {
        $self = new self;

        null !== $indices && $self['indices'] = $indices;
        null !== $seconds && $self['seconds'] = $seconds;
        null !== $text && $self['text'] = $text;
        null !== $tag && $self['tag'] = $tag;

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

    public function withSeconds(?float $seconds): self
    {
        $self = clone $this;
        $self['seconds'] = $seconds;

        return $self;
    }

    public function withText(?string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * X's SmartTag for a cashtag, smarttag or hashtag.
     *
     * @param TweetSmartTag|array<string,mixed>|null $tag
     */
    public function withTag(TweetSmartTag|array|null $tag): self
    {
        $self = clone $this;
        $self['tag'] = $tag;

        return $self;
    }
}
