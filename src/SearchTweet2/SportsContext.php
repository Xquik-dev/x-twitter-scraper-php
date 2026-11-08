<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\SearchTweet2;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\SearchTweet2\SportsContext\Competitors;

/**
 * @phpstan-type SportsContextShape = array{
 *   gameID?: string|null,
 *   league?: string|null,
 *   title?: string|null,
 *   url?: string|null,
 *   state?: string|null,
 *   statusText?: string|null,
 *   scheduledAtMs?: mixed,
 *   competitors?: list<Competitors|array<string,mixed>>|null,
 * }
 */
final class SportsContext implements BaseModel
{
    /** @use SdkModel<SportsContextShape> */
    use SdkModel;

    /**
     * Game ID.
     */
    #[Optional('gameId')]
    public ?string $gameID;

    /**
     * League ID.
     */
    #[Optional]
    public ?string $league;

    /**
     * Game title.
     */
    #[Optional]
    public ?string $title;

    /**
     * Game link.
     */
    #[Optional]
    public ?string $url;

    /**
     * Reported game state.
     */
    #[Optional]
    public ?string $state;

    /**
     * Game progress text.
     */
    #[Optional]
    public ?string $statusText;

    /**
     * Scheduled Unix milliseconds, retaining the source type.
     */
    #[Optional]
    public mixed $scheduledAtMs;

    /**
     * Teams & reported scores.
     *
     * @var list<Competitors>|null $competitors
     */
    #[Optional(list: Competitors::class)]
    public ?array $competitors;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Competitors|array<string,mixed>>|null $competitors
     */
    public static function with(?string $gameID = null, ?string $league = null, ?string $title = null, ?string $url = null, ?string $state = null, ?string $statusText = null, mixed $scheduledAtMs = null, ?array $competitors = null): self
    {
        $self = new self;

        null !== $gameID && $self['gameID'] = $gameID;
        null !== $league && $self['league'] = $league;
        null !== $title && $self['title'] = $title;
        null !== $url && $self['url'] = $url;
        null !== $state && $self['state'] = $state;
        null !== $statusText && $self['statusText'] = $statusText;
        null !== $scheduledAtMs && $self['scheduledAtMs'] = $scheduledAtMs;
        null !== $competitors && $self['competitors'] = $competitors;

        return $self;
    }

    /**
     * Game ID.
     */
    public function withGameID(?string $gameID): self
    {
        $self = clone $this;
        $self['gameID'] = $gameID;

        return $self;
    }

    /**
     * League ID.
     */
    public function withLeague(?string $league): self
    {
        $self = clone $this;
        $self['league'] = $league;

        return $self;
    }

    /**
     * Game title.
     */
    public function withTitle(?string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    /**
     * Game link.
     */
    public function withUrl(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Reported game state.
     */
    public function withState(?string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }

    /**
     * Game progress text.
     */
    public function withStatusText(?string $statusText): self
    {
        $self = clone $this;
        $self['statusText'] = $statusText;

        return $self;
    }

    /**
     * Scheduled Unix milliseconds, retaining the source type.
     */
    public function withScheduledAtMs(mixed $scheduledAtMs): self
    {
        $self = clone $this;
        $self['scheduledAtMs'] = $scheduledAtMs;

        return $self;
    }

    /**
     * Teams & reported scores.
     *
     * @param list<Competitors|array<string,mixed>>|null $competitors
     */
    public function withCompetitors(?array $competitors): self
    {
        $self = clone $this;
        $self['competitors'] = $competitors;

        return $self;
    }
}
