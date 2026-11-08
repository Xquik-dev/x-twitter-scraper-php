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
use XTwitterScraper\TweetAnalysisAnswer\Type;

/**
 * @phpstan-type TweetAnalysisAnswerShape = array{
 *   questionID: string,
 *   questionVersion: string,
 *   type: Type|value-of<Type>,
 *   value?: mixed,
 *   confidence?: float|null,
 *   probabilities?: array<string,mixed>|null,
 *   levels?: list<string>|null,
 *   probability?: float|null,
 * }
 */
final class TweetAnalysisAnswer implements BaseModel
{
    /** @use SdkModel<TweetAnalysisAnswerShape> */
    use SdkModel;

    #[Required('questionId')]
    public string $questionID;

    #[Required]
    public string $questionVersion;

    /**
     * @var value-of<Type> $type
     */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * The chosen category, or the level from 0, which can have decimals, such as 1.4 between levels 1 & 2.
     */
    #[Optional]
    public mixed $value;

    #[Optional]
    public ?float $confidence;

    /**
     * Probability of each category, or of each level by index.
     *
     * @var array<string,mixed>|null $probabilities
     */
    #[Optional(map: 'mixed')]
    public ?array $probabilities;

    /**
     * For a score. The levels the question named, from 0.
     *
     * @var list<string>|null $levels
     */
    #[Optional(list: 'string')]
    public ?array $levels;

    /**
     * For a probability. The chance the answer is yes.
     */
    #[Optional]
    public ?float $probability;

    /**
     * `new TweetAnalysisAnswer()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetAnalysisAnswer::with(questionID: ..., questionVersion: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetAnalysisAnswer)->withQuestionID(...)->withQuestionVersion(...)->withType(...)
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
     * @param Type|value-of<Type> $type
     * @param array<string,mixed>|null $probabilities
     * @param list<string>|null $levels
     */
    public static function with(string $questionID, string $questionVersion, Type|string $type, mixed $value = null, ?float $confidence = null, ?array $probabilities = null, ?array $levels = null, ?float $probability = null): self
    {
        $self = new self;

        $self['questionID'] = $questionID;
        $self['questionVersion'] = $questionVersion;
        $self['type'] = $type;

        null !== $value && $self['value'] = $value;
        null !== $confidence && $self['confidence'] = $confidence;
        null !== $probabilities && $self['probabilities'] = $probabilities;
        null !== $levels && $self['levels'] = $levels;
        null !== $probability && $self['probability'] = $probability;

        return $self;
    }

    public function withQuestionID(string $questionID): self
    {
        $self = clone $this;
        $self['questionID'] = $questionID;

        return $self;
    }

    public function withQuestionVersion(string $questionVersion): self
    {
        $self = clone $this;
        $self['questionVersion'] = $questionVersion;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The chosen category, or the level from 0, which can have decimals, such as 1.4 between levels 1 & 2.
     */
    public function withValue(mixed $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }

    public function withConfidence(?float $confidence): self
    {
        $self = clone $this;
        $self['confidence'] = $confidence;

        return $self;
    }

    /**
     * Probability of each category, or of each level by index.
     *
     * @param array<string,mixed>|null $probabilities
     */
    public function withProbabilities(?array $probabilities): self
    {
        $self = clone $this;
        $self['probabilities'] = $probabilities;

        return $self;
    }

    /**
     * For a score. The levels the question named, from 0.
     *
     * @param list<string>|null $levels
     */
    public function withLevels(?array $levels): self
    {
        $self = clone $this;
        $self['levels'] = $levels;

        return $self;
    }

    /**
     * For a probability. The chance the answer is yes.
     */
    public function withProbability(?float $probability): self
    {
        $self = clone $this;
        $self['probability'] = $probability;

        return $self;
    }
}
