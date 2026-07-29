<?php

declare(strict_types=1);

namespace XTwitterScraper\Compose\ComposeNewResponse;

use XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult\ContentRule;
use XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult\EngagementMultiplier;
use XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult\RadarRecommendation;
use XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult\SavedStyle;
use XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult\ScorerWeight;
use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ContentRuleShape from \XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult\ContentRule
 * @phpstan-import-type EngagementMultiplierShape from \XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult\EngagementMultiplier
 * @phpstan-import-type RadarRecommendationShape from \XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult\RadarRecommendation
 * @phpstan-import-type ScorerWeightShape from \XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult\ScorerWeight
 * @phpstan-import-type SavedStyleShape from \XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult\SavedStyle
 *
 * @phpstan-type ComposePrepareResultShape = array{
 *   contentRules: list<ContentRule|ContentRuleShape>,
 *   engagementMultipliers: list<EngagementMultiplier|EngagementMultiplierShape>,
 *   engagementVelocity: string,
 *   followUpQuestions: list<string>,
 *   intentURL: string,
 *   nextStep: string,
 *   radarRecommendations: list<RadarRecommendation|RadarRecommendationShape>,
 *   scorerWeights: list<ScorerWeight|ScorerWeightShape>,
 *   source: string,
 *   topPenalties: list<string>,
 *   savedStyles?: list<SavedStyle|SavedStyleShape>|null,
 *   styleNote?: string|null,
 *   styleTweets?: list<string>|null,
 * }
 */
final class ComposePrepareResult implements BaseModel
{
    /** @use SdkModel<ComposePrepareResultShape> */
    use SdkModel;

    /**
     * Xquik editorial heuristics, ordered for the goal.
     *
     * @var list<ContentRule> $contentRules
     */
    #[Required(list: ContentRule::class)]
    public array $contentRules;

    /**
     * Published engagement signal names. Production multipliers are not published.
     *
     * @var list<EngagementMultiplier> $engagementMultipliers
     */
    #[Required(list: EngagementMultiplier::class)]
    public array $engagementMultipliers;

    /**
     * Publication limit for timing and decay claims.
     */
    #[Required]
    public string $engagementVelocity;

    /** @var list<string> $followUpQuestions */
    #[Required(list: 'string')]
    public array $followUpQuestions;

    /**
     * X post intent seeded with the topic.
     */
    #[Required('intentUrl')]
    public string $intentURL;

    #[Required]
    public string $nextStep;

    /**
     * Sources and guidance for researching a fresh post angle.
     *
     * @var list<RadarRecommendation> $radarRecommendations
     */
    #[Required(list: RadarRecommendation::class)]
    public array $radarRecommendations;

    /**
     * Published signal names with unpublished weights as null.
     *
     * @var list<ScorerWeight> $scorerWeights
     */
    #[Required(list: ScorerWeight::class)]
    public array $scorerWeights;

    /**
     * Signal source and evidence limits.
     */
    #[Required]
    public string $source;

    /**
     * Negative engagement predictions in the public model.
     *
     * @var list<string> $topPenalties
     */
    #[Required(list: 'string')]
    public array $topPenalties;

    /**
     * Style analyses saved to the account.
     *
     * @var list<SavedStyle>|null $savedStyles
     */
    #[Optional(list: SavedStyle::class)]
    public ?array $savedStyles;

    /**
     * Next action when no cached style is available.
     */
    #[Optional]
    public ?string $styleNote;

    /**
     * Cached examples for the requested style username.
     *
     * @var list<string>|null $styleTweets
     */
    #[Optional(list: 'string')]
    public ?array $styleTweets;

    /**
     * `new ComposePrepareResult()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ComposePrepareResult::with(
     *   contentRules: ...,
     *   engagementMultipliers: ...,
     *   engagementVelocity: ...,
     *   followUpQuestions: ...,
     *   intentURL: ...,
     *   nextStep: ...,
     *   radarRecommendations: ...,
     *   scorerWeights: ...,
     *   source: ...,
     *   topPenalties: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ComposePrepareResult)
     *   ->withContentRules(...)
     *   ->withEngagementMultipliers(...)
     *   ->withEngagementVelocity(...)
     *   ->withFollowUpQuestions(...)
     *   ->withIntentURL(...)
     *   ->withNextStep(...)
     *   ->withRadarRecommendations(...)
     *   ->withScorerWeights(...)
     *   ->withSource(...)
     *   ->withTopPenalties(...)
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
     * @param list<ContentRule|ContentRuleShape> $contentRules
     * @param list<EngagementMultiplier|EngagementMultiplierShape> $engagementMultipliers
     * @param list<string> $followUpQuestions
     * @param list<RadarRecommendation|RadarRecommendationShape> $radarRecommendations
     * @param list<ScorerWeight|ScorerWeightShape> $scorerWeights
     * @param list<string> $topPenalties
     * @param list<SavedStyle|SavedStyleShape>|null $savedStyles
     * @param list<string>|null $styleTweets
     */
    public static function with(
        array $contentRules,
        array $engagementMultipliers,
        string $engagementVelocity,
        array $followUpQuestions,
        string $intentURL,
        string $nextStep,
        array $radarRecommendations,
        array $scorerWeights,
        string $source,
        array $topPenalties,
        ?array $savedStyles = null,
        ?string $styleNote = null,
        ?array $styleTweets = null,
    ): self {
        $self = new self;

        $self['contentRules'] = $contentRules;
        $self['engagementMultipliers'] = $engagementMultipliers;
        $self['engagementVelocity'] = $engagementVelocity;
        $self['followUpQuestions'] = $followUpQuestions;
        $self['intentURL'] = $intentURL;
        $self['nextStep'] = $nextStep;
        $self['radarRecommendations'] = $radarRecommendations;
        $self['scorerWeights'] = $scorerWeights;
        $self['source'] = $source;
        $self['topPenalties'] = $topPenalties;

        null !== $savedStyles && $self['savedStyles'] = $savedStyles;
        null !== $styleNote && $self['styleNote'] = $styleNote;
        null !== $styleTweets && $self['styleTweets'] = $styleTweets;

        return $self;
    }

    /**
     * Xquik editorial heuristics, ordered for the goal.
     *
     * @param list<ContentRule|ContentRuleShape> $contentRules
     */
    public function withContentRules(array $contentRules): self
    {
        $self = clone $this;
        $self['contentRules'] = $contentRules;

        return $self;
    }

    /**
     * Published engagement signal names. Production multipliers are not published.
     *
     * @param list<EngagementMultiplier|EngagementMultiplierShape> $engagementMultipliers
     */
    public function withEngagementMultipliers(
        array $engagementMultipliers
    ): self {
        $self = clone $this;
        $self['engagementMultipliers'] = $engagementMultipliers;

        return $self;
    }

    /**
     * Publication limit for timing and decay claims.
     */
    public function withEngagementVelocity(string $engagementVelocity): self
    {
        $self = clone $this;
        $self['engagementVelocity'] = $engagementVelocity;

        return $self;
    }

    /**
     * @param list<string> $followUpQuestions
     */
    public function withFollowUpQuestions(array $followUpQuestions): self
    {
        $self = clone $this;
        $self['followUpQuestions'] = $followUpQuestions;

        return $self;
    }

    /**
     * X post intent seeded with the topic.
     */
    public function withIntentURL(string $intentURL): self
    {
        $self = clone $this;
        $self['intentURL'] = $intentURL;

        return $self;
    }

    public function withNextStep(string $nextStep): self
    {
        $self = clone $this;
        $self['nextStep'] = $nextStep;

        return $self;
    }

    /**
     * Sources and guidance for researching a fresh post angle.
     *
     * @param list<RadarRecommendation|RadarRecommendationShape> $radarRecommendations
     */
    public function withRadarRecommendations(array $radarRecommendations): self
    {
        $self = clone $this;
        $self['radarRecommendations'] = $radarRecommendations;

        return $self;
    }

    /**
     * Published signal names with unpublished weights as null.
     *
     * @param list<ScorerWeight|ScorerWeightShape> $scorerWeights
     */
    public function withScorerWeights(array $scorerWeights): self
    {
        $self = clone $this;
        $self['scorerWeights'] = $scorerWeights;

        return $self;
    }

    /**
     * Signal source and evidence limits.
     */
    public function withSource(string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    /**
     * Negative engagement predictions in the public model.
     *
     * @param list<string> $topPenalties
     */
    public function withTopPenalties(array $topPenalties): self
    {
        $self = clone $this;
        $self['topPenalties'] = $topPenalties;

        return $self;
    }

    /**
     * Style analyses saved to the account.
     *
     * @param list<SavedStyle|SavedStyleShape> $savedStyles
     */
    public function withSavedStyles(array $savedStyles): self
    {
        $self = clone $this;
        $self['savedStyles'] = $savedStyles;

        return $self;
    }

    /**
     * Next action when no cached style is available.
     */
    public function withStyleNote(string $styleNote): self
    {
        $self = clone $this;
        $self['styleNote'] = $styleNote;

        return $self;
    }

    /**
     * Cached examples for the requested style username.
     *
     * @param list<string> $styleTweets
     */
    public function withStyleTweets(array $styleTweets): self
    {
        $self = clone $this;
        $self['styleTweets'] = $styleTweets;

        return $self;
    }
}
