<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\FootballProps\League;

/**
 * @phpstan-type FootballPropsShape = array{
 *   id: string,
 *   league: League|value-of<League>,
 *   sportsbookUrl: string|null,
 *   categories: list<FootballPropCategory|array<string,mixed>>,
 *   players: array<string,mixed>,
 * }
 */
final class FootballProps implements BaseModel
{
    /** @use SdkModel<FootballPropsShape> */
    use SdkModel;

    /**
     * The ID of the game these props cover.
     */
    #[Required]
    public string $id;

    /**
     * The league of the game these props cover.
     *
     * @var value-of<League> $league
     */
    #[Required(enum: League::class)]
    public string $league;

    /**
     * The sportsbook page X links for these props.
     */
    #[Required]
    public ?string $sportsbookUrl;

    /**
     * Each kind of prop, such as passing yards, in X's order. A game without props has none.
     *
     * @var list<FootballPropCategory> $categories
     */
    #[Required(list: FootballPropCategory::class)]
    public array $categories;

    /**
     * The players these props name, by player ID. X sends only each player's name, jersey & team, so other fields are null.
     *
     * @var array<string,mixed> $players
     */
    #[Required(map: 'mixed')]
    public array $players;

    /**
     * `new FootballProps()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballProps::with(id: ..., league: ..., sportsbookUrl: ..., categories: ..., players: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballProps)->withId(...)->withLeague(...)->withSportsbookUrl(...)->withCategories(...)->withPlayers(...)
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
     * @param League|value-of<League> $league
     * @param list<FootballPropCategory|array<string,mixed>> $categories
     * @param array<string,mixed> $players
     */
    public static function with(string $id, League|string $league, ?string $sportsbookUrl, array $categories, array $players): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['league'] = $league;
        $self['sportsbookUrl'] = $sportsbookUrl;
        $self['categories'] = $categories;
        $self['players'] = $players;

        return $self;
    }

    /**
     * The ID of the game these props cover.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The league of the game these props cover.
     *
     * @param League|value-of<League> $league
     */
    public function withLeague(League|string $league): self
    {
        $self = clone $this;
        $self['league'] = $league;

        return $self;
    }

    /**
     * The sportsbook page X links for these props.
     */
    public function withSportsbookUrl(?string $sportsbookUrl): self
    {
        $self = clone $this;
        $self['sportsbookUrl'] = $sportsbookUrl;

        return $self;
    }

    /**
     * Each kind of prop, such as passing yards, in X's order. A game without props has none.
     *
     * @param list<FootballPropCategory|array<string,mixed>> $categories
     */
    public function withCategories(array $categories): self
    {
        $self = clone $this;
        $self['categories'] = $categories;

        return $self;
    }

    /**
     * The players these props name, by player ID. X sends only each player's name, jersey & team, so other fields are null.
     *
     * @param array<string,mixed> $players
     */
    public function withPlayers(array $players): self
    {
        $self = clone $this;
        $self['players'] = $players;

        return $self;
    }
}
