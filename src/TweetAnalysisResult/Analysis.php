<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetAnalysisResult;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\TweetAnalysisAnswer;
use XTwitterScraper\TweetAnalysisResult\Analysis\ContextAvailability;
use XTwitterScraper\TweetAnalysisResult\Analysis\Questions;
use XTwitterScraper\TweetAnalysisResult\Analysis\Status;

/**
 * @phpstan-type AnalysisShape = array{
 *   status: Status|value-of<Status>,
 *   answers: list<TweetAnalysisAnswer|array<string,mixed>>,
 *   questions: list<Questions|array<string,mixed>>,
 *   contextBytes: int,
 *   contextAvailability: ContextAvailability|array<string,mixed>,
 * }
 */
final class Analysis implements BaseModel
{
    /** @use SdkModel<AnalysisShape> */
    use SdkModel;

    /**
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * 1 answer per question, in question order.
     *
     * @var list<TweetAnalysisAnswer> $answers
     */
    #[Required(list: TweetAnalysisAnswer::class)]
    public array $answers;

    /**
     * The ID & version of each question asked.
     *
     * @var list<Questions> $questions
     */
    #[Required(list: Questions::class)]
    public array $questions;

    /**
     * Bytes of post & settings the AI read.
     */
    #[Required]
    public int $contextBytes;

    /**
     * What the AI read beside the post's text.
     */
    #[Required]
    public ContextAvailability $contextAvailability;

    /**
     * `new Analysis()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Analysis::with(status: ..., answers: ..., questions: ..., contextBytes: ..., contextAvailability: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Analysis)->withStatus(...)->withAnswers(...)->withQuestions(...)->withContextBytes(...)->withContextAvailability(...)
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
     * @param Status|value-of<Status> $status
     * @param list<TweetAnalysisAnswer|array<string,mixed>> $answers
     * @param list<Questions|array<string,mixed>> $questions
     * @param ContextAvailability|array<string,mixed> $contextAvailability
     */
    public static function with(Status|string $status, array $answers, array $questions, int $contextBytes, ContextAvailability|array $contextAvailability): self
    {
        $self = new self;

        $self['status'] = $status;
        $self['answers'] = $answers;
        $self['questions'] = $questions;
        $self['contextBytes'] = $contextBytes;
        $self['contextAvailability'] = $contextAvailability;

        return $self;
    }

    /**
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * 1 answer per question, in question order.
     *
     * @param list<TweetAnalysisAnswer|array<string,mixed>> $answers
     */
    public function withAnswers(array $answers): self
    {
        $self = clone $this;
        $self['answers'] = $answers;

        return $self;
    }

    /**
     * The ID & version of each question asked.
     *
     * @param list<Questions|array<string,mixed>> $questions
     */
    public function withQuestions(array $questions): self
    {
        $self = clone $this;
        $self['questions'] = $questions;

        return $self;
    }

    /**
     * Bytes of post & settings the AI read.
     */
    public function withContextBytes(int $contextBytes): self
    {
        $self = clone $this;
        $self['contextBytes'] = $contextBytes;

        return $self;
    }

    /**
     * What the AI read beside the post's text.
     *
     * @param ContextAvailability|array<string,mixed> $contextAvailability
     */
    public function withContextAvailability(ContextAvailability|array $contextAvailability): self
    {
        $self = clone $this;
        $self['contextAvailability'] = $contextAvailability;

        return $self;
    }
}
