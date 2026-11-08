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
 * @phpstan-type UserHighlightsInfoShape = array{
 *   canHighlightTweets?: bool|null,
 *   highlightedTweets?: string|null,
 * }
 */
final class UserHighlightsInfo implements BaseModel
{
    /** @use SdkModel<UserHighlightsInfoShape> */
    use SdkModel;

    #[Optional]
    public ?bool $canHighlightTweets;

    #[Optional]
    public ?string $highlightedTweets;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?bool $canHighlightTweets = null, ?string $highlightedTweets = null): self
    {
        $self = new self;

        null !== $canHighlightTweets && $self['canHighlightTweets'] = $canHighlightTweets;
        null !== $highlightedTweets && $self['highlightedTweets'] = $highlightedTweets;

        return $self;
    }

    public function withCanHighlightTweets(?bool $canHighlightTweets): self
    {
        $self = clone $this;
        $self['canHighlightTweets'] = $canHighlightTweets;

        return $self;
    }

    public function withHighlightedTweets(?string $highlightedTweets): self
    {
        $self = clone $this;
        $self['highlightedTweets'] = $highlightedTweets;

        return $self;
    }
}
