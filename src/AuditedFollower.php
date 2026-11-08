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
 * @phpstan-type AuditedFollowerShape = array{
 *   class: FollowerClass|value-of<FollowerClass>,
 *   followers: int,
 *   following: int,
 *   id: string,
 *   likes: int,
 *   name: string,
 *   position: int,
 *   posts: int,
 *   score: int,
 *   signals: list<string>,
 *   userName: string,
 *   joinedAtMs?: int|null,
 *   owner?: string|null,
 *   pictureUrl?: string|null,
 * }
 */
final class AuditedFollower implements BaseModel
{
    /** @use SdkModel<AuditedFollowerShape> */
    use SdkModel;

    /**
     * What 1 follower looks like from its public profile.
     *
     * @var value-of<FollowerClass> $class
     */
    #[Required(enum: FollowerClass::class)]
    public string $class;

    #[Required]
    public int $followers;

    #[Required]
    public int $following;

    #[Required]
    public string $id;

    #[Required]
    public int $likes;

    #[Required]
    public string $name;

    #[Required]
    public int $position;

    #[Required]
    public int $posts;

    #[Required]
    public int $score;

    /**
     * @var list<string> $signals
     */
    #[Required(list: 'string')]
    public array $signals;

    #[Required]
    public string $userName;

    #[Optional]
    public ?int $joinedAtMs;

    /**
     * Account that runs an automated follower, when X names it.
     */
    #[Optional]
    public ?string $owner;

    #[Optional]
    public ?string $pictureUrl;

    /**
     * `new AuditedFollower()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AuditedFollower::with(class: ..., followers: ..., following: ..., id: ..., likes: ..., name: ..., position: ..., posts: ..., score: ..., signals: ..., userName: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AuditedFollower)->withClass(...)->withFollowers(...)->withFollowing(...)->withId(...)->withLikes(...)->withName(...)->withPosition(...)->withPosts(...)->withScore(...)->withSignals(...)->withUserName(...)
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
     * @param FollowerClass|value-of<FollowerClass> $class
     * @param list<string> $signals
     */
    public static function with(FollowerClass|string $class, int $followers, int $following, string $id, int $likes, string $name, int $position, int $posts, int $score, array $signals, string $userName, ?int $joinedAtMs = null, ?string $owner = null, ?string $pictureUrl = null): self
    {
        $self = new self;

        $self['class'] = $class;
        $self['followers'] = $followers;
        $self['following'] = $following;
        $self['id'] = $id;
        $self['likes'] = $likes;
        $self['name'] = $name;
        $self['position'] = $position;
        $self['posts'] = $posts;
        $self['score'] = $score;
        $self['signals'] = $signals;
        $self['userName'] = $userName;

        null !== $joinedAtMs && $self['joinedAtMs'] = $joinedAtMs;
        null !== $owner && $self['owner'] = $owner;
        null !== $pictureUrl && $self['pictureUrl'] = $pictureUrl;

        return $self;
    }

    /**
     * What 1 follower looks like from its public profile.
     *
     * @param FollowerClass|value-of<FollowerClass> $class
     */
    public function withClass(FollowerClass|string $class): self
    {
        $self = clone $this;
        $self['class'] = $class;

        return $self;
    }

    public function withFollowers(int $followers): self
    {
        $self = clone $this;
        $self['followers'] = $followers;

        return $self;
    }

    public function withFollowing(int $following): self
    {
        $self = clone $this;
        $self['following'] = $following;

        return $self;
    }

    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withLikes(int $likes): self
    {
        $self = clone $this;
        $self['likes'] = $likes;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withPosition(int $position): self
    {
        $self = clone $this;
        $self['position'] = $position;

        return $self;
    }

    public function withPosts(int $posts): self
    {
        $self = clone $this;
        $self['posts'] = $posts;

        return $self;
    }

    public function withScore(int $score): self
    {
        $self = clone $this;
        $self['score'] = $score;

        return $self;
    }

    /**
     * @param list<string> $signals
     */
    public function withSignals(array $signals): self
    {
        $self = clone $this;
        $self['signals'] = $signals;

        return $self;
    }

    public function withUserName(string $userName): self
    {
        $self = clone $this;
        $self['userName'] = $userName;

        return $self;
    }

    public function withJoinedAtMs(?int $joinedAtMs): self
    {
        $self = clone $this;
        $self['joinedAtMs'] = $joinedAtMs;

        return $self;
    }

    /**
     * Account that runs an automated follower, when X names it.
     */
    public function withOwner(?string $owner): self
    {
        $self = clone $this;
        $self['owner'] = $owner;

        return $self;
    }

    public function withPictureUrl(?string $pictureUrl): self
    {
        $self = clone $this;
        $self['pictureUrl'] = $pictureUrl;

        return $self;
    }
}
