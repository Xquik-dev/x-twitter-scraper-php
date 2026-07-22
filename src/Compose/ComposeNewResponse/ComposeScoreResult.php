<?php

declare(strict_types=1);

namespace XTwitterScraper\Compose\ComposeNewResponse;

use XTwitterScraper\Compose\ComposeNewResponse\ComposeScoreResult\Checklist;
use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ChecklistShape from \XTwitterScraper\Compose\ComposeNewResponse\ComposeScoreResult\Checklist
 *
 * @phpstan-type ComposeScoreResultShape = array{
 *   checklist: list<Checklist|ChecklistShape>,
 *   nextStep: string,
 *   passed: bool,
 *   passedCount: int,
 *   topSuggestion: string,
 *   totalChecks: 9,
 *   intentURL?: string|null,
 * }
 */
final class ComposeScoreResult implements BaseModel
{
    /** @use SdkModel<ComposeScoreResultShape> */
    use SdkModel;

    /** @var 9 $totalChecks */
    #[Required]
    public int $totalChecks = 9;

    /**
     * Deterministic editorial checks. Not a reach prediction.
     *
     * @var list<Checklist> $checklist
     */
    #[Required(list: Checklist::class)]
    public array $checklist;

    #[Required]
    public string $nextStep;

    #[Required]
    public bool $passed;

    #[Required]
    public int $passedCount;

    #[Required]
    public string $topSuggestion;

    /**
     * Present only when every check passes.
     */
    #[Optional('intentUrl')]
    public ?string $intentURL;

    /**
     * `new ComposeScoreResult()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ComposeScoreResult::with(
     *   checklist: ...,
     *   nextStep: ...,
     *   passed: ...,
     *   passedCount: ...,
     *   topSuggestion: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ComposeScoreResult)
     *   ->withChecklist(...)
     *   ->withNextStep(...)
     *   ->withPassed(...)
     *   ->withPassedCount(...)
     *   ->withTopSuggestion(...)
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
     * @param list<Checklist|ChecklistShape> $checklist
     */
    public static function with(
        array $checklist,
        string $nextStep,
        bool $passed,
        int $passedCount,
        string $topSuggestion,
        ?string $intentURL = null,
    ): self {
        $self = new self;

        $self['checklist'] = $checklist;
        $self['nextStep'] = $nextStep;
        $self['passed'] = $passed;
        $self['passedCount'] = $passedCount;
        $self['topSuggestion'] = $topSuggestion;

        null !== $intentURL && $self['intentURL'] = $intentURL;

        return $self;
    }

    /**
     * Deterministic editorial checks. Not a reach prediction.
     *
     * @param list<Checklist|ChecklistShape> $checklist
     */
    public function withChecklist(array $checklist): self
    {
        $self = clone $this;
        $self['checklist'] = $checklist;

        return $self;
    }

    public function withNextStep(string $nextStep): self
    {
        $self = clone $this;
        $self['nextStep'] = $nextStep;

        return $self;
    }

    public function withPassed(bool $passed): self
    {
        $self = clone $this;
        $self['passed'] = $passed;

        return $self;
    }

    public function withPassedCount(int $passedCount): self
    {
        $self = clone $this;
        $self['passedCount'] = $passedCount;

        return $self;
    }

    public function withTopSuggestion(string $topSuggestion): self
    {
        $self = clone $this;
        $self['topSuggestion'] = $topSuggestion;

        return $self;
    }

    /**
     * @param 9 $totalChecks
     */
    public function withTotalChecks(int $totalChecks): self
    {
        $self = clone $this;
        $self['totalChecks'] = $totalChecks;

        return $self;
    }

    /**
     * Present only when every check passes.
     */
    public function withIntentURL(string $intentURL): self
    {
        $self = clone $this;
        $self['intentURL'] = $intentURL;

        return $self;
    }
}
