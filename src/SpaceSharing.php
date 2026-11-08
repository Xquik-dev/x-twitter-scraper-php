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
 * @phpstan-type SpaceSharingShape = array{
 *   id?: string|null,
 *   sharedAt?: \DateTimeInterface|null,
 *   updatedAt?: \DateTimeInterface|null,
 *   sharedBy?: UserProfile|array<string,mixed>|null,
 *   tweet?: SearchTweet2|array<string,mixed>|null,
 * }
 */
final class SpaceSharing implements BaseModel
{
    /** @use SdkModel<SpaceSharingShape> */
    use SdkModel;

    /**
     * X's ID of the sharing, not of the post.
     */
    #[Optional]
    public ?string $id;

    /**
     * When the post was shared.
     */
    #[Optional]
    public ?\DateTimeInterface $sharedAt;

    /**
     * When X last changed the sharing.
     */
    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * Public X profile.
     */
    #[Optional]
    public ?UserProfile $sharedBy;

    /**
     * Search tweet with author. Zero metrics may mean X omitted counts.
     */
    #[Optional]
    public ?SearchTweet2 $tweet;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param UserProfile|array<string,mixed>|null $sharedBy
     * @param SearchTweet2|array<string,mixed>|null $tweet
     */
    public static function with(?string $id = null, ?\DateTimeInterface $sharedAt = null, ?\DateTimeInterface $updatedAt = null, UserProfile|array|null $sharedBy = null, SearchTweet2|array|null $tweet = null): self
    {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $sharedAt && $self['sharedAt'] = $sharedAt;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $sharedBy && $self['sharedBy'] = $sharedBy;
        null !== $tweet && $self['tweet'] = $tweet;

        return $self;
    }

    /**
     * X's ID of the sharing, not of the post.
     */
    public function withId(?string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * When the post was shared.
     */
    public function withSharedAt(?\DateTimeInterface $sharedAt): self
    {
        $self = clone $this;
        $self['sharedAt'] = $sharedAt;

        return $self;
    }

    /**
     * When X last changed the sharing.
     */
    public function withUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Public X profile.
     *
     * @param UserProfile|array<string,mixed>|null $sharedBy
     */
    public function withSharedBy(UserProfile|array|null $sharedBy): self
    {
        $self = clone $this;
        $self['sharedBy'] = $sharedBy;

        return $self;
    }

    /**
     * Search tweet with author. Zero metrics may mean X omitted counts.
     *
     * @param SearchTweet2|array<string,mixed>|null $tweet
     */
    public function withTweet(SearchTweet2|array|null $tweet): self
    {
        $self = clone $this;
        $self['tweet'] = $tweet;

        return $self;
    }
}
