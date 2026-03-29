<?php

declare(strict_types=1);

namespace XTwitterScraper\Drafts;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Drafts\DraftCreateParams\Goal;

/**
 * Save a tweet draft.
 *
 * @see XTwitterScraper\Services\DraftsService::create()
 *
 * @phpstan-type DraftCreateParamsShape = array{
 *   text: string, goal?: null|Goal|value-of<Goal>, topic?: string|null
 * }
 */
final class DraftCreateParams implements BaseModel
{
    /** @use SdkModel<DraftCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $text;

    /** @var value-of<Goal>|null $goal */
    #[Optional(enum: Goal::class)]
    public ?string $goal;

    #[Optional]
    public ?string $topic;

    /**
     * `new DraftCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DraftCreateParams::with(text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DraftCreateParams)->withText(...)
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
     * @param Goal|value-of<Goal>|null $goal
     */
    public static function with(
        string $text,
        Goal|string|null $goal = null,
        ?string $topic = null
    ): self {
        $self = new self;

        $self['text'] = $text;

        null !== $goal && $self['goal'] = $goal;
        null !== $topic && $self['topic'] = $topic;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * @param Goal|value-of<Goal> $goal
     */
    public function withGoal(Goal|string $goal): self
    {
        $self = clone $this;
        $self['goal'] = $goal;

        return $self;
    }

    public function withTopic(string $topic): self
    {
        $self = clone $this;
        $self['topic'] = $topic;

        return $self;
    }
}
