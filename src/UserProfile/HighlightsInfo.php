<?php

declare(strict_types=1);

namespace XTwitterScraper\UserProfile;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Profile highlight availability and count metadata.
 *
 * @phpstan-type HighlightsInfoShape = array{
 *   canHighlightTweets?: bool|null, highlightedTweets?: string|null
 * }
 */
final class HighlightsInfo implements BaseModel
{
    /** @use SdkModel<HighlightsInfoShape> */
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
    public static function with(
        ?bool $canHighlightTweets = null,
        ?string $highlightedTweets = null
    ): self {
        $self = new self;

        null !== $canHighlightTweets && $self['canHighlightTweets'] = $canHighlightTweets;
        null !== $highlightedTweets && $self['highlightedTweets'] = $highlightedTweets;

        return $self;
    }

    public function withCanHighlightTweets(bool $canHighlightTweets): self
    {
        $self = clone $this;
        $self['canHighlightTweets'] = $canHighlightTweets;

        return $self;
    }

    public function withHighlightedTweets(string $highlightedTweets): self
    {
        $self = clone $this;
        $self['highlightedTweets'] = $highlightedTweets;

        return $self;
    }
}
