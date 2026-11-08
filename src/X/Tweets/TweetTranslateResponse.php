<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\TweetTranslation;

/**
 * @phpstan-type TweetTranslateResponseShape = array{
 *   translation: TweetTranslation|array<string,mixed>,
 * }
 */
final class TweetTranslateResponse implements BaseModel
{
    /** @use SdkModel<TweetTranslateResponseShape> */
    use SdkModel;

    /**
     * Holds X's translation of 1 tweet into the requested language. `entities` holds the links, mentions, and tags with their offsets in the translated text, and is empty when the text has none.
     */
    #[Required]
    public TweetTranslation $translation;

    /**
     * `new TweetTranslateResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetTranslateResponse::with(translation: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetTranslateResponse)->withTranslation(...)
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
     * @param TweetTranslation|array<string,mixed> $translation
     */
    public static function with(TweetTranslation|array $translation): self
    {
        $self = new self;

        $self['translation'] = $translation;

        return $self;
    }

    /**
     * Holds X's translation of 1 tweet into the requested language. `entities` holds the links, mentions, and tags with their offsets in the translated text, and is empty when the text has none.
     *
     * @param TweetTranslation|array<string,mixed> $translation
     */
    public function withTranslation(TweetTranslation|array $translation): self
    {
        $self = clone $this;
        $self['translation'] = $translation;

        return $self;
    }
}
