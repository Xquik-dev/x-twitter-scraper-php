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
 * @phpstan-type CommunityNotesRatingOutcomeShape = array{
 *   helpfulCount?: int|null,
 *   notHelpfulCount?: int|null,
 *   total?: int|null,
 * }
 */
final class CommunityNotesRatingOutcome implements BaseModel
{
    /** @use SdkModel<CommunityNotesRatingOutcomeShape> */
    use SdkModel;

    /**
     * Ratings that called a note helpful.
     */
    #[Optional]
    public ?int $helpfulCount;

    /**
     * Ratings that called a note not helpful.
     */
    #[Optional]
    public ?int $notHelpfulCount;

    /**
     * All ratings in the group, when X sends the sum.
     */
    #[Optional]
    public ?int $total;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $helpfulCount = null, ?int $notHelpfulCount = null, ?int $total = null): self
    {
        $self = new self;

        null !== $helpfulCount && $self['helpfulCount'] = $helpfulCount;
        null !== $notHelpfulCount && $self['notHelpfulCount'] = $notHelpfulCount;
        null !== $total && $self['total'] = $total;

        return $self;
    }

    /**
     * Ratings that called a note helpful.
     */
    public function withHelpfulCount(?int $helpfulCount): self
    {
        $self = clone $this;
        $self['helpfulCount'] = $helpfulCount;

        return $self;
    }

    /**
     * Ratings that called a note not helpful.
     */
    public function withNotHelpfulCount(?int $notHelpfulCount): self
    {
        $self = clone $this;
        $self['notHelpfulCount'] = $notHelpfulCount;

        return $self;
    }

    /**
     * All ratings in the group, when X sends the sum.
     */
    public function withTotal(?int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }
}
