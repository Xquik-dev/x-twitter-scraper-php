<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetDetail;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\UserProfile;

/**
 * @phpstan-type ReactionContextShape = array{
 *   reactedToPost?: array<string,mixed>|null,
 *   reactedToPostID?: string|null,
 *   reactedToUser?: UserProfile|array<string,mixed>|null,
 * }
 */
final class ReactionContext implements BaseModel
{
    /** @use SdkModel<ReactionContextShape> */
    use SdkModel;

    /**
     * The post this one reacts to, with the same fields. X often sends only its ID, author & edit history. Then unknownFields lists text, and the flags X did not send are left out.
     *
     * @var array<string,mixed>|null $reactedToPost
     */
    #[Optional(map: 'mixed')]
    public ?array $reactedToPost;

    /**
     * Referenced post ID.
     */
    #[Optional('reactedToPostId')]
    public ?string $reactedToPostID;

    /**
     * Public X profile.
     */
    #[Optional]
    public ?UserProfile $reactedToUser;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,mixed>|null $reactedToPost
     * @param UserProfile|array<string,mixed>|null $reactedToUser
     */
    public static function with(?array $reactedToPost = null, ?string $reactedToPostID = null, UserProfile|array|null $reactedToUser = null): self
    {
        $self = new self;

        null !== $reactedToPost && $self['reactedToPost'] = $reactedToPost;
        null !== $reactedToPostID && $self['reactedToPostID'] = $reactedToPostID;
        null !== $reactedToUser && $self['reactedToUser'] = $reactedToUser;

        return $self;
    }

    /**
     * The post this one reacts to, with the same fields. X often sends only its ID, author & edit history. Then unknownFields lists text, and the flags X did not send are left out.
     *
     * @param array<string,mixed>|null $reactedToPost
     */
    public function withReactedToPost(?array $reactedToPost): self
    {
        $self = clone $this;
        $self['reactedToPost'] = $reactedToPost;

        return $self;
    }

    /**
     * Referenced post ID.
     */
    public function withReactedToPostID(?string $reactedToPostID): self
    {
        $self = clone $this;
        $self['reactedToPostID'] = $reactedToPostID;

        return $self;
    }

    /**
     * Public X profile.
     *
     * @param UserProfile|array<string,mixed>|null $reactedToUser
     */
    public function withReactedToUser(UserProfile|array|null $reactedToUser): self
    {
        $self = clone $this;
        $self['reactedToUser'] = $reactedToUser;

        return $self;
    }
}
