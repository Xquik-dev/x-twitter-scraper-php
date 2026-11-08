<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CommunityNotesContributorShape = array{
 *   alias: string,
 *   isTopWriter?: bool|null,
 *   isApiContributor?: bool|null,
 *   deletedNotesCount?: int|null,
 *   notesCount?: CommunityNotesNoteCounts|array<string,mixed>|null,
 *   ratingsCount?: CommunityNotesRatingCounts|array<string,mixed>|null,
 * }
 */
final class CommunityNotesContributor implements BaseModel
{
    /** @use SdkModel<CommunityNotesContributorShape> */
    use SdkModel;

    /**
     * The alias X gives the contributor.
     */
    #[Required]
    public string $alias;

    /**
     * Whether X marks the contributor as a top writer.
     */
    #[Optional]
    public ?bool $isTopWriter;

    /**
     * Whether the contributor writes notes through X's API.
     */
    #[Optional]
    public ?bool $isApiContributor;

    /**
     * Notes the contributor deleted.
     */
    #[Optional]
    public ?int $deletedNotesCount;

    /**
     * How many notes a contributor wrote, by X's current rating.
     */
    #[Optional]
    public ?CommunityNotesNoteCounts $notesCount;

    /**
     * How a contributor's ratings of other notes went.
     */
    #[Optional]
    public ?CommunityNotesRatingCounts $ratingsCount;

    /**
     * `new CommunityNotesContributor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CommunityNotesContributor::with(alias: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CommunityNotesContributor)->withAlias(...)
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
     * @param CommunityNotesNoteCounts|array<string,mixed>|null $notesCount
     * @param CommunityNotesRatingCounts|array<string,mixed>|null $ratingsCount
     */
    public static function with(string $alias, ?bool $isTopWriter = null, ?bool $isApiContributor = null, ?int $deletedNotesCount = null, CommunityNotesNoteCounts|array|null $notesCount = null, CommunityNotesRatingCounts|array|null $ratingsCount = null): self
    {
        $self = new self;

        $self['alias'] = $alias;

        null !== $isTopWriter && $self['isTopWriter'] = $isTopWriter;
        null !== $isApiContributor && $self['isApiContributor'] = $isApiContributor;
        null !== $deletedNotesCount && $self['deletedNotesCount'] = $deletedNotesCount;
        null !== $notesCount && $self['notesCount'] = $notesCount;
        null !== $ratingsCount && $self['ratingsCount'] = $ratingsCount;

        return $self;
    }

    /**
     * The alias X gives the contributor.
     */
    public function withAlias(string $alias): self
    {
        $self = clone $this;
        $self['alias'] = $alias;

        return $self;
    }

    /**
     * Whether X marks the contributor as a top writer.
     */
    public function withIsTopWriter(?bool $isTopWriter): self
    {
        $self = clone $this;
        $self['isTopWriter'] = $isTopWriter;

        return $self;
    }

    /**
     * Whether the contributor writes notes through X's API.
     */
    public function withIsApiContributor(?bool $isApiContributor): self
    {
        $self = clone $this;
        $self['isApiContributor'] = $isApiContributor;

        return $self;
    }

    /**
     * Notes the contributor deleted.
     */
    public function withDeletedNotesCount(?int $deletedNotesCount): self
    {
        $self = clone $this;
        $self['deletedNotesCount'] = $deletedNotesCount;

        return $self;
    }

    /**
     * How many notes a contributor wrote, by X's current rating.
     *
     * @param CommunityNotesNoteCounts|array<string,mixed>|null $notesCount
     */
    public function withNotesCount(CommunityNotesNoteCounts|array|null $notesCount): self
    {
        $self = clone $this;
        $self['notesCount'] = $notesCount;

        return $self;
    }

    /**
     * How a contributor's ratings of other notes went.
     *
     * @param CommunityNotesRatingCounts|array<string,mixed>|null $ratingsCount
     */
    public function withRatingsCount(CommunityNotesRatingCounts|array|null $ratingsCount): self
    {
        $self = clone $this;
        $self['ratingsCount'] = $ratingsCount;

        return $self;
    }
}
