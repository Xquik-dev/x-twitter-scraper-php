<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Analysis\AnalysisMarketSignalsParams;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Analysis\AnalysisMarketSignalsParams\Baseline\Monitor;
use XTwitterScraper\X\Analysis\AnalysisMarketSignalsParams\Baseline\Tweet;

/**
 * @phpstan-type BaselineShape = array{
 *   answers: array<string,mixed>,
 *   id?: string|null,
 *   tweet?: Tweet|array<string,mixed>|null,
 *   monitor?: Monitor|array<string,mixed>|null,
 * }
 */
final class Baseline implements BaseModel
{
    /** @use SdkModel<BaselineShape> */
    use SdkModel;

    /**
     * The earlier answers by question ID.
     *
     * @var array<string,mixed> $answers
     */
    #[Required(map: 'mixed')]
    public array $answers;

    /**
     * Post ID, or text:1 & so on. Otherwise tweet.id counts.
     */
    #[Optional]
    public ?string $id;

    #[Optional]
    public ?Tweet $tweet;

    /**
     * The earlier row's monitor, with its fingerprint.
     */
    #[Optional]
    public ?Monitor $monitor;

    /**
     * `new Baseline()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Baseline::with(answers: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Baseline)->withAnswers(...)
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
     * @param array<string,mixed> $answers
     * @param Tweet|array<string,mixed>|null $tweet
     * @param Monitor|array<string,mixed>|null $monitor
     */
    public static function with(array $answers, ?string $id = null, Tweet|array|null $tweet = null, Monitor|array|null $monitor = null): self
    {
        $self = new self;

        $self['answers'] = $answers;

        null !== $id && $self['id'] = $id;
        null !== $tweet && $self['tweet'] = $tweet;
        null !== $monitor && $self['monitor'] = $monitor;

        return $self;
    }

    /**
     * The earlier answers by question ID.
     *
     * @param array<string,mixed> $answers
     */
    public function withAnswers(array $answers): self
    {
        $self = clone $this;
        $self['answers'] = $answers;

        return $self;
    }

    /**
     * Post ID, or text:1 & so on. Otherwise tweet.id counts.
     */
    public function withId(?string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param Tweet|array<string,mixed>|null $tweet
     */
    public function withTweet(Tweet|array|null $tweet): self
    {
        $self = clone $this;
        $self['tweet'] = $tweet;

        return $self;
    }

    /**
     * The earlier row's monitor, with its fingerprint.
     *
     * @param Monitor|array<string,mixed>|null $monitor
     */
    public function withMonitor(Monitor|array|null $monitor): self
    {
        $self = clone $this;
        $self['monitor'] = $monitor;

        return $self;
    }
}
