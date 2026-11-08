<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetAnalysisSummary;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TargetsShape = array{
 *   name: string,
 *   mentions: int,
 *   share: float,
 *   engagement: int,
 *   choices: array<string,mixed>,
 *   top: array<string,mixed>,
 * }
 */
final class Targets implements BaseModel
{
    /** @use SdkModel<TargetsShape> */
    use SdkModel;

    #[Required]
    public string $name;

    #[Required]
    public int $mentions;

    #[Required]
    public float $share;

    #[Required]
    public int $engagement;

    /**
     * Category counts by question ID.
     *
     * @var array<string,mixed> $choices
     */
    #[Required(map: 'mixed')]
    public array $choices;

    /**
     * The most engaged posts per question ID & category.
     *
     * @var array<string,mixed> $top
     */
    #[Required(map: 'mixed')]
    public array $top;

    /**
     * `new Targets()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Targets::with(name: ..., mentions: ..., share: ..., engagement: ..., choices: ..., top: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Targets)->withName(...)->withMentions(...)->withShare(...)->withEngagement(...)->withChoices(...)->withTop(...)
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
     * @param array<string,mixed> $choices
     * @param array<string,mixed> $top
     */
    public static function with(string $name, int $mentions, float $share, int $engagement, array $choices, array $top): self
    {
        $self = new self;

        $self['name'] = $name;
        $self['mentions'] = $mentions;
        $self['share'] = $share;
        $self['engagement'] = $engagement;
        $self['choices'] = $choices;
        $self['top'] = $top;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withMentions(int $mentions): self
    {
        $self = clone $this;
        $self['mentions'] = $mentions;

        return $self;
    }

    public function withShare(float $share): self
    {
        $self = clone $this;
        $self['share'] = $share;

        return $self;
    }

    public function withEngagement(int $engagement): self
    {
        $self = clone $this;
        $self['engagement'] = $engagement;

        return $self;
    }

    /**
     * Category counts by question ID.
     *
     * @param array<string,mixed> $choices
     */
    public function withChoices(array $choices): self
    {
        $self = clone $this;
        $self['choices'] = $choices;

        return $self;
    }

    /**
     * The most engaged posts per question ID & category.
     *
     * @param array<string,mixed> $top
     */
    public function withTop(array $top): self
    {
        $self = clone $this;
        $self['top'] = $top;

        return $self;
    }
}
