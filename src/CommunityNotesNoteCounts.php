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
 * @phpstan-type CommunityNotesNoteCountsShape = array{
 *   awaitingMoreRatings?: int|null,
 *   currentlyRatedHelpful?: int|null,
 *   currentlyRatedNotHelpful?: int|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class CommunityNotesNoteCounts implements BaseModel
{
    /** @use SdkModel<CommunityNotesNoteCountsShape> */
    use SdkModel;

    /**
     * Notes that need more ratings.
     */
    #[Optional]
    public ?int $awaitingMoreRatings;

    /**
     * Notes X rates helpful now.
     */
    #[Optional]
    public ?int $currentlyRatedHelpful;

    /**
     * Notes X rates not helpful now.
     */
    #[Optional]
    public ?int $currentlyRatedNotHelpful;

    /**
     * When X last counted the notes.
     */
    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $awaitingMoreRatings = null, ?int $currentlyRatedHelpful = null, ?int $currentlyRatedNotHelpful = null, ?\DateTimeInterface $updatedAt = null): self
    {
        $self = new self;

        null !== $awaitingMoreRatings && $self['awaitingMoreRatings'] = $awaitingMoreRatings;
        null !== $currentlyRatedHelpful && $self['currentlyRatedHelpful'] = $currentlyRatedHelpful;
        null !== $currentlyRatedNotHelpful && $self['currentlyRatedNotHelpful'] = $currentlyRatedNotHelpful;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Notes that need more ratings.
     */
    public function withAwaitingMoreRatings(?int $awaitingMoreRatings): self
    {
        $self = clone $this;
        $self['awaitingMoreRatings'] = $awaitingMoreRatings;

        return $self;
    }

    /**
     * Notes X rates helpful now.
     */
    public function withCurrentlyRatedHelpful(?int $currentlyRatedHelpful): self
    {
        $self = clone $this;
        $self['currentlyRatedHelpful'] = $currentlyRatedHelpful;

        return $self;
    }

    /**
     * Notes X rates not helpful now.
     */
    public function withCurrentlyRatedNotHelpful(?int $currentlyRatedNotHelpful): self
    {
        $self = clone $this;
        $self['currentlyRatedNotHelpful'] = $currentlyRatedNotHelpful;

        return $self;
    }

    /**
     * When X last counted the notes.
     */
    public function withUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
