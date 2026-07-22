<?php

declare(strict_types=1);

namespace XTwitterScraper\Compose\ComposeNewResponse;

use XTwitterScraper\Compose\ComposeNewResponse\ComposeRefineResult\ExamplePattern;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ExamplePatternShape from \XTwitterScraper\Compose\ComposeNewResponse\ComposeRefineResult\ExamplePattern
 *
 * @phpstan-type ComposeRefineResultShape = array{
 *   compositionGuidance: list<string>,
 *   examplePatterns: list<ExamplePattern|ExamplePatternShape>,
 *   intentURL: string,
 *   nextStep: string,
 * }
 */
final class ComposeRefineResult implements BaseModel
{
    /** @use SdkModel<ComposeRefineResultShape> */
    use SdkModel;

    /**
     * Goal, tone, media, and editorial guidance.
     *
     * @var list<string> $compositionGuidance
     */
    #[Required(list: 'string')]
    public array $compositionGuidance;

    /** @var list<ExamplePattern> $examplePatterns */
    #[Required(list: ExamplePattern::class)]
    public array $examplePatterns;

    /**
     * X post intent seeded with the topic.
     */
    #[Required('intentUrl')]
    public string $intentURL;

    #[Required]
    public string $nextStep;

    /**
     * `new ComposeRefineResult()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ComposeRefineResult::with(
     *   compositionGuidance: ..., examplePatterns: ..., intentURL: ..., nextStep: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ComposeRefineResult)
     *   ->withCompositionGuidance(...)
     *   ->withExamplePatterns(...)
     *   ->withIntentURL(...)
     *   ->withNextStep(...)
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
     * @param list<string> $compositionGuidance
     * @param list<ExamplePattern|ExamplePatternShape> $examplePatterns
     */
    public static function with(
        array $compositionGuidance,
        array $examplePatterns,
        string $intentURL,
        string $nextStep,
    ): self {
        $self = new self;

        $self['compositionGuidance'] = $compositionGuidance;
        $self['examplePatterns'] = $examplePatterns;
        $self['intentURL'] = $intentURL;
        $self['nextStep'] = $nextStep;

        return $self;
    }

    /**
     * Goal, tone, media, and editorial guidance.
     *
     * @param list<string> $compositionGuidance
     */
    public function withCompositionGuidance(array $compositionGuidance): self
    {
        $self = clone $this;
        $self['compositionGuidance'] = $compositionGuidance;

        return $self;
    }

    /**
     * @param list<ExamplePattern|ExamplePatternShape> $examplePatterns
     */
    public function withExamplePatterns(array $examplePatterns): self
    {
        $self = clone $this;
        $self['examplePatterns'] = $examplePatterns;

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
}
