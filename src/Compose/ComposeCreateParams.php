<?php

declare(strict_types=1);

namespace XTwitterScraper\Compose;

use XTwitterScraper\Compose\ComposeCreateParams\Goal;
use XTwitterScraper\Compose\ComposeCreateParams\MediaType;
use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Run one step of Xquik's three-step writing workflow. Compose returns questions, editorial rules, and source-specific Radar recommendations. Refine returns goal-specific guidance. Score applies deterministic text checks. It does not predict reach or expose X ranking weights.
 *
 * @see XTwitterScraper\Services\ComposeService::create()
 *
 * @phpstan-type ComposeCreateParamsShape = array{
 *   step: 'score',
 *   topic: string,
 *   goal: Goal|value-of<Goal>,
 *   styleUsername?: string|null,
 *   tone: string,
 *   additionalContext?: string|null,
 *   callToAction?: string|null,
 *   mediaType?: null|MediaType|value-of<MediaType>,
 *   draft: string,
 *   hasLink?: bool|null,
 *   hasMedia?: bool|null,
 * }
 */
final class ComposeCreateParams implements BaseModel
{
    /** @use SdkModel<ComposeCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /** @var 'score' $step */
    #[Required]
    public string $step = 'score';

    /**
     * Subject for the post.
     */
    #[Required]
    public string $topic;

    /**
     * Editorial goal for the guidance.
     *
     * @var value-of<Goal> $goal
     */
    #[Required(enum: Goal::class)]
    public string $goal;

    /**
     * Username from a style analysis saved to this account.
     */
    #[Optional]
    public ?string $styleUsername;

    /**
     * Requested writing tone.
     */
    #[Required]
    public string $tone;

    /**
     * Audience, constraints, sources, or other writing context.
     */
    #[Optional]
    public ?string $additionalContext;

    /**
     * Specific action the draft should request.
     */
    #[Optional]
    public ?string $callToAction;

    /**
     * Planned media type.
     *
     * @var value-of<MediaType>|null $mediaType
     */
    #[Optional(enum: MediaType::class)]
    public ?string $mediaType;

    /**
     * Full post text for deterministic editorial checks.
     */
    #[Required]
    public string $draft;

    /**
     * True when a separate link card is attached.
     */
    #[Optional]
    public ?bool $hasLink;

    /**
     * @deprecated Ignored. Remove this field. Use hasLink for a separate link card.
     *
     * Accepted for backward compatibility. Text checks ignore this field.
     */
    #[Optional]
    public ?bool $hasMedia;

    /**
     * `new ComposeCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ComposeCreateParams::with(topic: ..., goal: ..., tone: ..., draft: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ComposeCreateParams)
     *   ->withTopic(...)
     *   ->withGoal(...)
     *   ->withTone(...)
     *   ->withDraft(...)
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
     * @param Goal|value-of<Goal> $goal
     * @param MediaType|value-of<MediaType>|null $mediaType
     */
    public static function with(
        string $topic,
        Goal|string $goal,
        string $tone,
        string $draft,
        ?string $styleUsername = null,
        ?string $additionalContext = null,
        ?string $callToAction = null,
        MediaType|string|null $mediaType = null,
        ?bool $hasLink = null,
        ?bool $hasMedia = null,
    ): self {
        $self = new self;

        $self['topic'] = $topic;
        $self['goal'] = $goal;
        $self['tone'] = $tone;
        $self['draft'] = $draft;

        null !== $styleUsername && $self['styleUsername'] = $styleUsername;
        null !== $additionalContext && $self['additionalContext'] = $additionalContext;
        null !== $callToAction && $self['callToAction'] = $callToAction;
        null !== $mediaType && $self['mediaType'] = $mediaType;
        null !== $hasLink && $self['hasLink'] = $hasLink;
        null !== $hasMedia && $self['hasMedia'] = $hasMedia;

        return $self;
    }

    /**
     * @param 'score' $step
     */
    public function withStep(string $step): self
    {
        $self = clone $this;
        $self['step'] = $step;

        return $self;
    }

    /**
     * Subject for the post.
     */
    public function withTopic(string $topic): self
    {
        $self = clone $this;
        $self['topic'] = $topic;

        return $self;
    }

    /**
     * Editorial goal for the guidance.
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
     * Username from a style analysis saved to this account.
     */
    public function withStyleUsername(string $styleUsername): self
    {
        $self = clone $this;
        $self['styleUsername'] = $styleUsername;

        return $self;
    }

    /**
     * Requested writing tone.
     */
    public function withTone(string $tone): self
    {
        $self = clone $this;
        $self['tone'] = $tone;

        return $self;
    }

    /**
     * Audience, constraints, sources, or other writing context.
     */
    public function withAdditionalContext(string $additionalContext): self
    {
        $self = clone $this;
        $self['additionalContext'] = $additionalContext;

        return $self;
    }

    /**
     * Specific action the draft should request.
     */
    public function withCallToAction(string $callToAction): self
    {
        $self = clone $this;
        $self['callToAction'] = $callToAction;

        return $self;
    }

    /**
     * Planned media type.
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
     * Full post text for deterministic editorial checks.
     */
    public function withDraft(string $draft): self
    {
        $self = clone $this;
        $self['draft'] = $draft;

        return $self;
    }

    /**
     * True when a separate link card is attached.
     */
    public function withHasLink(bool $hasLink): self
    {
        $self = clone $this;
        $self['hasLink'] = $hasLink;

        return $self;
    }

    /**
     * Accepted for backward compatibility. Text checks ignore this field.
     */
    public function withHasMedia(bool $hasMedia): self
    {
        $self = clone $this;
        $self['hasMedia'] = $hasMedia;

        return $self;
    }
}
