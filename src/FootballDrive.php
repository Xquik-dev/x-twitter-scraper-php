<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type FootballDriveShape = array{
 *   id: string|null,
 *   sequence: int|null,
 *   offense: string|null,
 *   defense: string|null,
 *   startClock: string|null,
 *   endClock: string|null,
 *   startReason: string|null,
 *   endReason: string|null,
 *   playCount: int|null,
 *   firstDowns: int|null,
 *   netYards: int|null,
 *   scoring: bool|null,
 *   plays: list<FootballPlay|array<string,mixed>>,
 * }
 */
final class FootballDrive implements BaseModel
{
    /** @use SdkModel<FootballDriveShape> */
    use SdkModel;

    /**
     * X's ID for the drive within the game.
     */
    #[Required]
    public ?string $id;

    /**
     * The drive's place in the game, from 1.
     */
    #[Required]
    public ?int $sequence;

    /**
     * The team that drove. Home or Away in NFL games, the team's alternateId in college games.
     */
    #[Required]
    public ?string $offense;

    /**
     * The team on defense. X stopped sending it on 2026-10-24, so it is null.
     */
    #[Required]
    public ?string $defense;

    /**
     * The game clock when the drive started, as HH:MM:SS.
     */
    #[Required]
    public ?string $startClock;

    /**
     * The game clock when the drive ended, as HH:MM:SS.
     */
    #[Required]
    public ?string $endClock;

    /**
     * How the drive started, such as Kickoff or Punt. X stopped sending it on 2026-10-24, so it is null.
     */
    #[Required]
    public ?string $startReason;

    /**
     * How the drive ended, such as Touchdown or Punt.
     */
    #[Required]
    public ?string $endReason;

    /**
     * The drive's plays.
     */
    #[Required]
    public ?int $playCount;

    /**
     * The first downs the drive gained. X stopped sending it on 2026-10-24, so it is null.
     */
    #[Required]
    public ?int $firstDowns;

    /**
     * The yards the drive gained.
     */
    #[Required]
    public ?int $netYards;

    /**
     * Whether the drive scored. X stopped sending it on 2026-10-24, so it is null. Each play still says whether it scored.
     */
    #[Required]
    public ?bool $scoring;

    /**
     * The drive's plays, in order.
     *
     * @var list<FootballPlay> $plays
     */
    #[Required(list: FootballPlay::class)]
    public array $plays;

    /**
     * `new FootballDrive()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballDrive::with(id: ..., sequence: ..., offense: ..., defense: ..., startClock: ..., endClock: ..., startReason: ..., endReason: ..., playCount: ..., firstDowns: ..., netYards: ..., scoring: ..., plays: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballDrive)->withId(...)->withSequence(...)->withOffense(...)->withDefense(...)->withStartClock(...)->withEndClock(...)->withStartReason(...)->withEndReason(...)->withPlayCount(...)->withFirstDowns(...)->withNetYards(...)->withScoring(...)->withPlays(...)
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
     * @param list<FootballPlay|array<string,mixed>> $plays
     */
    public static function with(?string $id, ?int $sequence, ?string $offense, ?string $defense, ?string $startClock, ?string $endClock, ?string $startReason, ?string $endReason, ?int $playCount, ?int $firstDowns, ?int $netYards, ?bool $scoring, array $plays): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['sequence'] = $sequence;
        $self['offense'] = $offense;
        $self['defense'] = $defense;
        $self['startClock'] = $startClock;
        $self['endClock'] = $endClock;
        $self['startReason'] = $startReason;
        $self['endReason'] = $endReason;
        $self['playCount'] = $playCount;
        $self['firstDowns'] = $firstDowns;
        $self['netYards'] = $netYards;
        $self['scoring'] = $scoring;
        $self['plays'] = $plays;

        return $self;
    }

    /**
     * X's ID for the drive within the game.
     */
    public function withId(?string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The drive's place in the game, from 1.
     */
    public function withSequence(?int $sequence): self
    {
        $self = clone $this;
        $self['sequence'] = $sequence;

        return $self;
    }

    /**
     * The team that drove. Home or Away in NFL games, the team's alternateId in college games.
     */
    public function withOffense(?string $offense): self
    {
        $self = clone $this;
        $self['offense'] = $offense;

        return $self;
    }

    /**
     * The team on defense. X stopped sending it on 2026-10-24, so it is null.
     */
    public function withDefense(?string $defense): self
    {
        $self = clone $this;
        $self['defense'] = $defense;

        return $self;
    }

    /**
     * The game clock when the drive started, as HH:MM:SS.
     */
    public function withStartClock(?string $startClock): self
    {
        $self = clone $this;
        $self['startClock'] = $startClock;

        return $self;
    }

    /**
     * The game clock when the drive ended, as HH:MM:SS.
     */
    public function withEndClock(?string $endClock): self
    {
        $self = clone $this;
        $self['endClock'] = $endClock;

        return $self;
    }

    /**
     * How the drive started, such as Kickoff or Punt. X stopped sending it on 2026-10-24, so it is null.
     */
    public function withStartReason(?string $startReason): self
    {
        $self = clone $this;
        $self['startReason'] = $startReason;

        return $self;
    }

    /**
     * How the drive ended, such as Touchdown or Punt.
     */
    public function withEndReason(?string $endReason): self
    {
        $self = clone $this;
        $self['endReason'] = $endReason;

        return $self;
    }

    /**
     * The drive's plays.
     */
    public function withPlayCount(?int $playCount): self
    {
        $self = clone $this;
        $self['playCount'] = $playCount;

        return $self;
    }

    /**
     * The first downs the drive gained. X stopped sending it on 2026-10-24, so it is null.
     */
    public function withFirstDowns(?int $firstDowns): self
    {
        $self = clone $this;
        $self['firstDowns'] = $firstDowns;

        return $self;
    }

    /**
     * The yards the drive gained.
     */
    public function withNetYards(?int $netYards): self
    {
        $self = clone $this;
        $self['netYards'] = $netYards;

        return $self;
    }

    /**
     * Whether the drive scored. X stopped sending it on 2026-10-24, so it is null. Each play still says whether it scored.
     */
    public function withScoring(?bool $scoring): self
    {
        $self = clone $this;
        $self['scoring'] = $scoring;

        return $self;
    }

    /**
     * The drive's plays, in order.
     *
     * @param list<FootballPlay|array<string,mixed>> $plays
     */
    public function withPlays(array $plays): self
    {
        $self = clone $this;
        $self['plays'] = $plays;

        return $self;
    }
}
