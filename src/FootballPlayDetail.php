<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\FootballPlayDetail\Penalty;
use XTwitterScraper\FootballPlayDetail\Players;

/**
 * @phpstan-type FootballPlayDetailShape = array{
 *   sequence: int|null,
 *   category: string|null,
 *   description: string|null,
 *   direction: string|null,
 *   yards: int|null,
 *   players: list<Players|array<string,mixed>>,
 *   penalty: Penalty|array<string,mixed>|null,
 * }
 */
final class FootballPlayDetail implements BaseModel
{
    /** @use SdkModel<FootballPlayDetailShape> */
    use SdkModel;

    /**
     * The step's place in the play, from 1.
     */
    #[Required]
    public ?int $sequence;

    /**
     * X's kind of step, such as Pass, Tackle or Penalty.
     */
    #[Required]
    public ?string $category;

    /**
     * What happened in the step.
     */
    #[Required]
    public ?string $description;

    /**
     * The direction X gives for the step.
     */
    #[Required]
    public ?string $direction;

    /**
     * The yards the step gained or lost.
     */
    #[Required]
    public ?int $yards;

    /**
     * The players in the step & their roles.
     *
     * @var list<Players> $players
     */
    #[Required(list: Players::class)]
    public array $players;

    /**
     * The penalty this step called, or null.
     */
    #[Required]
    public ?Penalty $penalty;

    /**
     * `new FootballPlayDetail()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballPlayDetail::with(sequence: ..., category: ..., description: ..., direction: ..., yards: ..., players: ..., penalty: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballPlayDetail)->withSequence(...)->withCategory(...)->withDescription(...)->withDirection(...)->withYards(...)->withPlayers(...)->withPenalty(...)
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
     * @param list<Players|array<string,mixed>> $players
     * @param Penalty|array<string,mixed>|null $penalty
     */
    public static function with(?int $sequence, ?string $category, ?string $description, ?string $direction, ?int $yards, array $players, Penalty|array|null $penalty): self
    {
        $self = new self;

        $self['sequence'] = $sequence;
        $self['category'] = $category;
        $self['description'] = $description;
        $self['direction'] = $direction;
        $self['yards'] = $yards;
        $self['players'] = $players;
        $self['penalty'] = $penalty;

        return $self;
    }

    /**
     * The step's place in the play, from 1.
     */
    public function withSequence(?int $sequence): self
    {
        $self = clone $this;
        $self['sequence'] = $sequence;

        return $self;
    }

    /**
     * X's kind of step, such as Pass, Tackle or Penalty.
     */
    public function withCategory(?string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    /**
     * What happened in the step.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * The direction X gives for the step.
     */
    public function withDirection(?string $direction): self
    {
        $self = clone $this;
        $self['direction'] = $direction;

        return $self;
    }

    /**
     * The yards the step gained or lost.
     */
    public function withYards(?int $yards): self
    {
        $self = clone $this;
        $self['yards'] = $yards;

        return $self;
    }

    /**
     * The players in the step & their roles.
     *
     * @param list<Players|array<string,mixed>> $players
     */
    public function withPlayers(array $players): self
    {
        $self = clone $this;
        $self['players'] = $players;

        return $self;
    }

    /**
     * The penalty this step called, or null.
     *
     * @param Penalty|array<string,mixed>|null $penalty
     */
    public function withPenalty(Penalty|array|null $penalty): self
    {
        $self = clone $this;
        $self['penalty'] = $penalty;

        return $self;
    }
}
