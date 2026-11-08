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
 * @phpstan-type TweetHashtagShape = array{
 *   text: string,
 *   indices?: list<int>|null,
 *   tag?: TweetSmartTag|array<string,mixed>|null,
 * }
 */
final class TweetHashtag implements BaseModel
{
    /** @use SdkModel<TweetHashtagShape> */
    use SdkModel;

    #[Required]
    public string $text;

    /**
     * @var list<int>|null $indices
     */
    #[Optional(list: 'int')]
    public ?array $indices;

    /**
     * X's SmartTag for a cashtag, smarttag or hashtag.
     */
    #[Optional]
    public ?TweetSmartTag $tag;

    /**
     * `new TweetHashtag()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetHashtag::with(text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetHashtag)->withText(...)
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
     *
     * @param list<int>|null $indices
     * @param TweetSmartTag|array<string,mixed>|null $tag
     */
    public static function with(string $text, ?array $indices = null, TweetSmartTag|array|null $tag = null): self
    {
        $self = new self;

        $self['text'] = $text;

        null !== $indices && $self['indices'] = $indices;
        null !== $tag && $self['tag'] = $tag;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

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
