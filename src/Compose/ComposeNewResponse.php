<?php

declare(strict_types=1);

namespace XTwitterScraper\Compose;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ComposeNewResponseShape = array{
 *   feedback?: string|null,
 *   score?: float|null,
 *   suggestions?: list<string>|null,
 *   text?: string|null,
 * }
 */
final class ComposeNewResponse implements BaseModel
{
    /** @use SdkModel<ComposeNewResponseShape> */
    use SdkModel;

    /**
     * AI feedback on the draft.
     */
    #[Optional]
    public ?string $feedback;

    /**
     * Engagement score (0-100).
     */
    #[Optional]
    public ?float $score;

    /**
     * Improvement suggestions.
     *
     * @var list<string>|null $suggestions
     */
    #[Optional(list: 'string')]
    public ?array $suggestions;

    /**
     * Generated or refined tweet text.
     */
    #[Optional]
    public ?string $text;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $suggestions
     */
    public static function with(
        ?string $feedback = null,
        ?float $score = null,
        ?array $suggestions = null,
        ?string $text = null,
    ): self {
        $self = new self;

        null !== $feedback && $self['feedback'] = $feedback;
        null !== $score && $self['score'] = $score;
        null !== $suggestions && $self['suggestions'] = $suggestions;
        null !== $text && $self['text'] = $text;

        return $self;
    }

    /**
     * AI feedback on the draft.
     */
    public function withFeedback(string $feedback): self
    {
        $self = clone $this;
        $self['feedback'] = $feedback;

        return $self;
    }

    /**
     * Engagement score (0-100).
     */
    public function withScore(float $score): self
    {
        $self = clone $this;
        $self['score'] = $score;

        return $self;
    }

    /**
     * Improvement suggestions.
     *
     * @param list<string> $suggestions
     */
    public function withSuggestions(array $suggestions): self
    {
        $self = clone $this;
        $self['suggestions'] = $suggestions;

        return $self;
    }

    /**
     * Generated or refined tweet text.
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }
}
