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
 * @phpstan-type PlayersShape = array{
 *   playerID: string|null,
 *   playerRole: string|null,
 * }
 */
final class Players implements BaseModel
{
    /** @use SdkModel<PlayersShape> */
    use SdkModel;

    /**
     * The player, a key of players.
     */
    #[Required('playerId')]
    public ?string $playerID;

    /**
     * The player's role, such as Pass, Receive or Tackle.
     */
    #[Required]
    public ?string $playerRole;

    /**
     * `new Players()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Players::with(playerID: ..., playerRole: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Players)->withPlayerID(...)->withPlayerRole(...)
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
    public static function with(?string $playerID, ?string $playerRole): self
    {
        $self = new self;

        $self['playerID'] = $playerID;
        $self['playerRole'] = $playerRole;

        return $self;
    }

    /**
     * The player, a key of players.
     */
    public function withPlayerID(?string $playerID): self
    {
        $self = clone $this;
        $self['playerID'] = $playerID;

        return $self;
    }

    /**
     * The player's role, such as Pass, Receive or Tackle.
     */
    public function withPlayerRole(?string $playerRole): self
    {
        $self = clone $this;
        $self['playerRole'] = $playerRole;

        return $self;
    }
}
