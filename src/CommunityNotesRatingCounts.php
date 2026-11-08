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
 * @phpstan-type CommunityNotesRatingCountsShape = array{
 *   awaitingMoreRatings?: int|null,
 *   ratedAfterDecision?: int|null,
 *   successful?: CommunityNotesRatingOutcome|array<string,mixed>|null,
 *   unsuccessful?: CommunityNotesRatingOutcome|array<string,mixed>|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class CommunityNotesRatingCounts implements BaseModel
{
    /** @use SdkModel<CommunityNotesRatingCountsShape> */
    use SdkModel;

    /**
     * Ratings on notes that need more ratings.
     */
    #[Optional]
    public ?int $awaitingMoreRatings;

    /**
     * Ratings made after X rated the note.
     */
    #[Optional]
    public ?int $ratedAfterDecision;

    /**
     * Ratings that matched the rating X gave the note.
     */
    #[Optional]
    public ?CommunityNotesRatingOutcome $successful;

    /**
     * Ratings that went against the rating X gave the note.
     */
    #[Optional]
    public ?CommunityNotesRatingOutcome $unsuccessful;

    /**
     * When X last counted the ratings.
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
     *
     * @param CommunityNotesRatingOutcome|array<string,mixed>|null $successful
     * @param CommunityNotesRatingOutcome|array<string,mixed>|null $unsuccessful
     */
    public static function with(?int $awaitingMoreRatings = null, ?int $ratedAfterDecision = null, CommunityNotesRatingOutcome|array|null $successful = null, CommunityNotesRatingOutcome|array|null $unsuccessful = null, ?\DateTimeInterface $updatedAt = null): self
    {
        $self = new self;

        null !== $awaitingMoreRatings && $self['awaitingMoreRatings'] = $awaitingMoreRatings;
        null !== $ratedAfterDecision && $self['ratedAfterDecision'] = $ratedAfterDecision;
        null !== $successful && $self['successful'] = $successful;
        null !== $unsuccessful && $self['unsuccessful'] = $unsuccessful;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Ratings on notes that need more ratings.
     */
    public function withAwaitingMoreRatings(?int $awaitingMoreRatings): self
    {
        $self = clone $this;
        $self['awaitingMoreRatings'] = $awaitingMoreRatings;

        return $self;
    }

    /**
     * Ratings made after X rated the note.
     */
    public function withRatedAfterDecision(?int $ratedAfterDecision): self
    {
        $self = clone $this;
        $self['ratedAfterDecision'] = $ratedAfterDecision;

        return $self;
    }

    /**
     * Ratings that matched the rating X gave the note.
     *
     * @param CommunityNotesRatingOutcome|array<string,mixed>|null $successful
     */
    public function withSuccessful(CommunityNotesRatingOutcome|array|null $successful): self
    {
        $self = clone $this;
        $self['successful'] = $successful;

        return $self;
    }

    /**
     * Ratings that went against the rating X gave the note.
     *
     * @param CommunityNotesRatingOutcome|array<string,mixed>|null $unsuccessful
     */
    public function withUnsuccessful(CommunityNotesRatingOutcome|array|null $unsuccessful): self
    {
        $self = clone $this;
        $self['unsuccessful'] = $unsuccessful;

        return $self;
    }

    /**
     * When X last counted the ratings.
     */
    public function withUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
