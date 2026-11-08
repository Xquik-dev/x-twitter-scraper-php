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
 * @phpstan-type TweetEditShape = array{
 *   editTweetIDs?: list<string>|null,
 *   editableUntilMsecs?: string|null,
 *   initialTweetID?: string|null,
 * }
 */
final class TweetEdit implements BaseModel
{
    /** @use SdkModel<TweetEditShape> */
    use SdkModel;

    /**
     * @var list<string>|null $editTweetIDs
     */
    #[Optional('editTweetIds', list: 'string')]
    public ?array $editTweetIDs;

    #[Optional]
    public ?string $editableUntilMsecs;

    #[Optional('initialTweetId')]
    public ?string $initialTweetID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $editTweetIDs
     */
    public static function with(?array $editTweetIDs = null, ?string $editableUntilMsecs = null, ?string $initialTweetID = null): self
    {
        $self = new self;

        null !== $editTweetIDs && $self['editTweetIDs'] = $editTweetIDs;
        null !== $editableUntilMsecs && $self['editableUntilMsecs'] = $editableUntilMsecs;
        null !== $initialTweetID && $self['initialTweetID'] = $initialTweetID;

        return $self;
    }

    /**
     * @param list<string>|null $editTweetIDs
     */
    public function withEditTweetIDs(?array $editTweetIDs): self
    {
        $self = clone $this;
        $self['editTweetIDs'] = $editTweetIDs;

        return $self;
    }

    public function withEditableUntilMsecs(?string $editableUntilMsecs): self
    {
        $self = clone $this;
        $self['editableUntilMsecs'] = $editableUntilMsecs;

        return $self;
    }

    public function withInitialTweetID(?string $initialTweetID): self
    {
        $self = clone $this;
        $self['initialTweetID'] = $initialTweetID;

        return $self;
    }
}
