<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\TweetEmbed;

/**
 * @phpstan-type TweetEmbedResponseShape = array{
 *   embed: TweetEmbed|array<string,mixed>,
 * }
 */
final class TweetEmbedResponse implements BaseModel
{
    /** @use SdkModel<TweetEmbedResponseShape> */
    use SdkModel;

    /**
     * Holds the HTML that embeds 1 tweet on a website.
     */
    #[Required]
    public TweetEmbed $embed;

    /**
     * `new TweetEmbedResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetEmbedResponse::with(embed: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetEmbedResponse)->withEmbed(...)
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
     * @param TweetEmbed|array<string,mixed> $embed
     */
    public static function with(TweetEmbed|array $embed): self
    {
        $self = new self;

        $self['embed'] = $embed;

        return $self;
    }

    /**
     * Holds the HTML that embeds 1 tweet on a website.
     *
     * @param TweetEmbed|array<string,mixed> $embed
     */
    public function withEmbed(TweetEmbed|array $embed): self
    {
        $self = clone $this;
        $self['embed'] = $embed;

        return $self;
    }
}
