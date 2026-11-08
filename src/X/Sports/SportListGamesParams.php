<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Sports;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Lists NFL or college football games in a time window, with teams & scores. Use it to find game IDs & team IDs. Without from or to, X picks about 5 weeks around today. Each request costs 1 credit.
 *
 * @see XTwitterScraper\Services\X\SportsService::listGames()
 *
 * @phpstan-type SportListGamesParamsShape = array{
 *   from?: string|null,
 *   to?: string|null,
 *   team?: string|null,
 *   fields?: string|null,
 *   omit?: string|null,
 * }
 */
final class SportListGamesParams implements BaseModel
{
    /** @use SdkModel<SportListGamesParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Start of the window. Takes an ISO 8601 date or time, such as 2026-10-01, or Unix seconds. A time without a zone reads as UTC. Defaults to 7 days before to. Alias sinceTime.
     */
    #[Optional]
    public ?string $from;

    /**
     * End of the window. Takes the forms of from. Defaults to 7 days after from. Alias untilTime.
     */
    #[Optional]
    public ?string $to;

    /**
     * Keeps only 1 team's games, by team ID. Each game lists its teamIds. Aliases teamId & team_id.
     */
    #[Optional]
    public ?string $team;

    /**
     * Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     */
    #[Optional]
    public ?string $fields;

    /**
     * Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     */
    #[Optional]
    public ?string $omit;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $from = null, ?string $to = null, ?string $team = null, ?string $fields = null, ?string $omit = null): self
    {
        $self = new self;

        null !== $from && $self['from'] = $from;
        null !== $to && $self['to'] = $to;
        null !== $team && $self['team'] = $team;
        null !== $fields && $self['fields'] = $fields;
        null !== $omit && $self['omit'] = $omit;

        return $self;
    }

    /**
     * Start of the window. Takes an ISO 8601 date or time, such as 2026-10-01, or Unix seconds. A time without a zone reads as UTC. Defaults to 7 days before to. Alias sinceTime.
     */
    public function withFrom(?string $from): self
    {
        $self = clone $this;
        $self['from'] = $from;

        return $self;
    }

    /**
     * End of the window. Takes the forms of from. Defaults to 7 days after from. Alias untilTime.
     */
    public function withTo(?string $to): self
    {
        $self = clone $this;
        $self['to'] = $to;

        return $self;
    }

    /**
     * Keeps only 1 team's games, by team ID. Each game lists its teamIds. Aliases teamId & team_id.
     */
    public function withTeam(?string $team): self
    {
        $self = clone $this;
        $self['team'] = $team;

        return $self;
    }

    /**
     * Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     */
    public function withFields(?string $fields): self
    {
        $self = clone $this;
        $self['fields'] = $fields;

        return $self;
    }

    /**
     * Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     */
    public function withOmit(?string $omit): self
    {
        $self = clone $this;
        $self['omit'] = $omit;

        return $self;
    }
}
