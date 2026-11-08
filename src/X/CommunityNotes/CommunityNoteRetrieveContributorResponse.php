<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\CommunityNotes;

use XTwitterScraper\CommunityNotesContributor;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CommunityNoteRetrieveContributorResponseShape = array{
 *   contributor: CommunityNotesContributor|array<string,mixed>,
 * }
 */
final class CommunityNoteRetrieveContributorResponse implements BaseModel
{
    /** @use SdkModel<CommunityNoteRetrieveContributorResponseShape> */
    use SdkModel;

    /**
     * A Community Notes contributor. X names contributors by an alias, never by their X account. A field X leaves out is left out. Beside a note, X sends its writer with only some of the counts.
     */
    #[Required]
    public CommunityNotesContributor $contributor;

    /**
     * `new CommunityNoteRetrieveContributorResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CommunityNoteRetrieveContributorResponse::with(contributor: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CommunityNoteRetrieveContributorResponse)->withContributor(...)
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
     * @param CommunityNotesContributor|array<string,mixed> $contributor
     */
    public static function with(CommunityNotesContributor|array $contributor): self
    {
        $self = new self;

        $self['contributor'] = $contributor;

        return $self;
    }

    /**
     * A Community Notes contributor. X names contributors by an alias, never by their X account. A field X leaves out is left out. Beside a note, X sends its writer with only some of the counts.
     *
     * @param CommunityNotesContributor|array<string,mixed> $contributor
     */
    public function withContributor(CommunityNotesContributor|array $contributor): self
    {
        $self = clone $this;
        $self['contributor'] = $contributor;

        return $self;
    }
}
