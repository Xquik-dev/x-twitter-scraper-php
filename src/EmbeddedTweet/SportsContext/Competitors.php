<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\EmbeddedTweet\SportsContext;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CompetitorsShape = array{
 *   teamID?: string|null,
 *   color?: string|null,
 *   isActive?: bool|null,
 *   isWinner?: bool|null,
 *   abbreviation?: string|null,
 *   name?: string|null,
 *   score?: string|null,
 *   logoUrl?: string|null,
 *   darkLogoUrl?: string|null,
 * }
 */
final class Competitors implements BaseModel
{
    /** @use SdkModel<CompetitorsShape> */
    use SdkModel;

    /**
     * Team ID.
     */
    #[Optional('teamId')]
    public ?string $teamID;

    /**
     * Team display color.
     */
    #[Optional]
    public ?string $color;

    /**
     * Active competitor.
     */
    #[Optional]
    public ?bool $isActive;

    /**
     * Winning competitor.
     */
    #[Optional]
    public ?bool $isWinner;

    /**
     * Team abbreviation.
     */
    #[Optional]
    public ?string $abbreviation;

    /**
     * Team name.
     */
    #[Optional]
    public ?string $name;

    /**
     * Score display text.
     */
    #[Optional]
    public ?string $score;

    /**
     * Logo for light backgrounds.
     */
    #[Optional]
    public ?string $logoUrl;

    /**
     * Logo for dark backgrounds.
     */
    #[Optional]
    public ?string $darkLogoUrl;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $teamID = null, ?string $color = null, ?bool $isActive = null, ?bool $isWinner = null, ?string $abbreviation = null, ?string $name = null, ?string $score = null, ?string $logoUrl = null, ?string $darkLogoUrl = null): self
    {
        $self = new self;

        null !== $teamID && $self['teamID'] = $teamID;
        null !== $color && $self['color'] = $color;
        null !== $isActive && $self['isActive'] = $isActive;
        null !== $isWinner && $self['isWinner'] = $isWinner;
        null !== $abbreviation && $self['abbreviation'] = $abbreviation;
        null !== $name && $self['name'] = $name;
        null !== $score && $self['score'] = $score;
        null !== $logoUrl && $self['logoUrl'] = $logoUrl;
        null !== $darkLogoUrl && $self['darkLogoUrl'] = $darkLogoUrl;

        return $self;
    }

    /**
     * Team ID.
     */
    public function withTeamID(?string $teamID): self
    {
        $self = clone $this;
        $self['teamID'] = $teamID;

        return $self;
    }

    /**
     * Team display color.
     */
    public function withColor(?string $color): self
    {
        $self = clone $this;
        $self['color'] = $color;

        return $self;
    }

    /**
     * Active competitor.
     */
    public function withIsActive(?bool $isActive): self
    {
        $self = clone $this;
        $self['isActive'] = $isActive;

        return $self;
    }

    /**
     * Winning competitor.
     */
    public function withIsWinner(?bool $isWinner): self
    {
        $self = clone $this;
        $self['isWinner'] = $isWinner;

        return $self;
    }

    /**
     * Team abbreviation.
     */
    public function withAbbreviation(?string $abbreviation): self
    {
        $self = clone $this;
        $self['abbreviation'] = $abbreviation;

        return $self;
    }

    /**
     * Team name.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Score display text.
     */
    public function withScore(?string $score): self
    {
        $self = clone $this;
        $self['score'] = $score;

        return $self;
    }

    /**
     * Logo for light backgrounds.
     */
    public function withLogoUrl(?string $logoUrl): self
    {
        $self = clone $this;
        $self['logoUrl'] = $logoUrl;

        return $self;
    }

    /**
     * Logo for dark backgrounds.
     */
    public function withDarkLogoUrl(?string $darkLogoUrl): self
    {
        $self = clone $this;
        $self['darkLogoUrl'] = $darkLogoUrl;

        return $self;
    }
}
