<?php

declare(strict_types=1);

namespace XTwitterScraper\Compose;

use XTwitterScraper\Compose\ComposeCreateParams\Goal;
use XTwitterScraper\Compose\ComposeCreateParams\MediaType;
use XTwitterScraper\Compose\ComposeCreateParams\Step;
use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Compose, refine, or score a tweet.
 *
 * @see XTwitterScraper\Services\ComposeService::create()
 *
 * @phpstan-type ComposeCreateParamsShape = array{
 *   step: Step|value-of<Step>,
 *   additionalContext?: string|null,
 *   callToAction?: string|null,
 *   draft?: string|null,
 *   goal?: null|Goal|value-of<Goal>,
 *   hasLink?: bool|null,
 *   hasMedia?: bool|null,
 *   mediaType?: null|MediaType|value-of<MediaType>,
 *   styleUsername?: string|null,
 *   tone?: string|null,
 *   topic?: string|null,
 * }
 */
final class ComposeCreateParams implements BaseModel
{
    /** @use SdkModel<ComposeCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Workflow step.
     *
     * @var value-of<Step> $step
     */
    #[Required(enum: Step::class)]
    public string $step;

    /**
     * Extra context or URLs (refine).
     */
    #[Optional]
    public ?string $additionalContext;

    /**
     * Desired call to action (refine).
     */
    #[Optional]
    public ?string $callToAction;

    /**
     * Tweet draft text to evaluate (score).
     */
    #[Optional]
    public ?string $draft;

    /**
     * Optimization goal.
     *
     * @var value-of<Goal>|null $goal
     */
    #[Optional(enum: Goal::class)]
    public ?string $goal;

    /**
     * Whether a link is attached (score).
     */
    #[Optional]
    public ?bool $hasLink;

    /**
     * Whether media is attached (score).
     */
    #[Optional]
    public ?bool $hasMedia;

    /**
     * Media type (refine).
     *
     * @var value-of<MediaType>|null $mediaType
     */
    #[Optional(enum: MediaType::class)]
    public ?string $mediaType;

    /**
     * Cached style username for voice matching (compose).
     */
    #[Optional]
    public ?string $styleUsername;

    /**
     * Desired tone (refine).
     */
    #[Optional]
    public ?string $tone;

    /**
     * Tweet topic (compose, refine).
     */
    #[Optional]
    public ?string $topic;

    /**
     * `new ComposeCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ComposeCreateParams::with(step: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ComposeCreateParams)->withStep(...)
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
     * @param Step|value-of<Step> $step
     * @param Goal|value-of<Goal>|null $goal
     * @param MediaType|value-of<MediaType>|null $mediaType
     */
    public static function with(
        Step|string $step,
        ?string $additionalContext = null,
        ?string $callToAction = null,
        ?string $draft = null,
        Goal|string|null $goal = null,
        ?bool $hasLink = null,
        ?bool $hasMedia = null,
        MediaType|string|null $mediaType = null,
        ?string $styleUsername = null,
        ?string $tone = null,
        ?string $topic = null,
    ): self {
        $self = new self;

        $self['step'] = $step;

        null !== $additionalContext && $self['additionalContext'] = $additionalContext;
        null !== $callToAction && $self['callToAction'] = $callToAction;
        null !== $draft && $self['draft'] = $draft;
        null !== $goal && $self['goal'] = $goal;
        null !== $hasLink && $self['hasLink'] = $hasLink;
        null !== $hasMedia && $self['hasMedia'] = $hasMedia;
        null !== $mediaType && $self['mediaType'] = $mediaType;
        null !== $styleUsername && $self['styleUsername'] = $styleUsername;
        null !== $tone && $self['tone'] = $tone;
        null !== $topic && $self['topic'] = $topic;

        return $self;
    }

    /**
     * Workflow step.
     *
     * @param Step|value-of<Step> $step
     */
    public function withStep(Step|string $step): self
    {
        $self = clone $this;
        $self['step'] = $step;

        return $self;
    }

    /**
     * Extra context or URLs (refine).
     */
    public function withAdditionalContext(string $additionalContext): self
    {
        $self = clone $this;
        $self['additionalContext'] = $additionalContext;

        return $self;
    }

    /**
     * Desired call to action (refine).
     */
    public function withCallToAction(string $callToAction): self
    {
        $self = clone $this;
        $self['callToAction'] = $callToAction;

        return $self;
    }

    /**
     * Tweet draft text to evaluate (score).
     */
    public function withDraft(string $draft): self
    {
        $self = clone $this;
        $self['draft'] = $draft;

        return $self;
    }

    /**
     * Optimization goal.
     *
     * @param Goal|value-of<Goal> $goal
     */
    public function withGoal(Goal|string $goal): self
    {
        $self = clone $this;
        $self['goal'] = $goal;

        return $self;
    }

    /**
     * Whether a link is attached (score).
     */
    public function withHasLink(bool $hasLink): self
    {
        $self = clone $this;
        $self['hasLink'] = $hasLink;

        return $self;
    }

    /**
     * Whether media is attached (score).
     */
    public function withHasMedia(bool $hasMedia): self
    {
        $self = clone $this;
        $self['hasMedia'] = $hasMedia;

        return $self;
    }

    /**
     * Media type (refine).
     *
     * @param MediaType|value-of<MediaType> $mediaType
     */
    public function withMediaType(MediaType|string $mediaType): self
    {
        $self = clone $this;
        $self['mediaType'] = $mediaType;

        return $self;
    }

    /**
     * Cached style username for voice matching (compose).
     */
    public function withStyleUsername(string $styleUsername): self
    {
        $self = clone $this;
        $self['styleUsername'] = $styleUsername;

        return $self;
    }

    /**
     * Desired tone (refine).
     */
    public function withTone(string $tone): self
    {
        $self = clone $this;
        $self['tone'] = $tone;

        return $self;
    }

    /**
     * Tweet topic (compose, refine).
     */
    public function withTopic(string $topic): self
    {
        $self = clone $this;
        $self['topic'] = $topic;

        return $self;
    }
}
