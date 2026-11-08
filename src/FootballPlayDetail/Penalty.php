<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\FootballPlayDetail;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type PenaltyShape = array{
 *   description: string|null,
 *   nextDown: string|null,
 *   result: string|null,
 *   teamID: string|null,
 *   yards: int|null,
 * }
 */
final class Penalty implements BaseModel
{
    /** @use SdkModel<PenaltyShape> */
    use SdkModel;

    /**
     * The penalty's name.
     */
    #[Required]
    public ?string $description;

    /**
     * What the penalty does to the down.
     */
    #[Required]
    public ?string $nextDown;

    /**
     * Whether the penalty was accepted or declined.
     */
    #[Required]
    public ?string $result;

    /**
     * The penalized team, a key of teams.
     */
    #[Required('teamId')]
    public ?string $teamID;

    /**
     * The penalty's yards.
     */
    #[Required]
    public ?int $yards;

    /**
     * `new Penalty()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Penalty::with(description: ..., nextDown: ..., result: ..., teamID: ..., yards: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Penalty)->withDescription(...)->withNextDown(...)->withResult(...)->withTeamID(...)->withYards(...)
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
     */
    public static function with(?string $description, ?string $nextDown, ?string $result, ?string $teamID, ?int $yards): self
    {
        $self = new self;

        $self['description'] = $description;
        $self['nextDown'] = $nextDown;
        $self['result'] = $result;
        $self['teamID'] = $teamID;
        $self['yards'] = $yards;

        return $self;
    }

    /**
     * The penalty's name.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * What the penalty does to the down.
     */
    public function withNextDown(?string $nextDown): self
    {
        $self = clone $this;
        $self['nextDown'] = $nextDown;

        return $self;
    }

    /**
     * Whether the penalty was accepted or declined.
     */
    public function withResult(?string $result): self
    {
        $self = clone $this;
        $self['result'] = $result;

        return $self;
    }

    /**
     * The penalized team, a key of teams.
     */
    public function withTeamID(?string $teamID): self
    {
        $self = clone $this;
        $self['teamID'] = $teamID;

        return $self;
    }

    /**
     * The penalty's yards.
     */
    public function withYards(?int $yards): self
    {
        $self = clone $this;
        $self['yards'] = $yards;

        return $self;
    }
}
