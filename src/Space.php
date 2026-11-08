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
 * @phpstan-type SpaceShape = array{
 *   id: string,
 *   admins: list<SpaceParticipant|array<string,mixed>>,
 *   speakers: list<SpaceParticipant|array<string,mixed>>,
 *   listeners: list<SpaceParticipant|array<string,mixed>>,
 *   title?: string|null,
 *   state?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   scheduledStart?: \DateTimeInterface|null,
 *   startedAt?: \DateTimeInterface|null,
 *   endedAt?: \DateTimeInterface|null,
 *   updatedAt?: \DateTimeInterface|null,
 *   totalLiveListeners?: int|null,
 *   totalReplayWatched?: int|null,
 *   participantCount?: int|null,
 *   isAvailableForReplay?: bool|null,
 *   isAvailableForClipping?: bool|null,
 *   isLocked?: bool|null,
 *   isEmployeeOnly?: bool|null,
 *   disallowJoin?: bool|null,
 *   noIncognito?: bool|null,
 *   contentType?: string|null,
 *   conversationControls?: int|null,
 *   maxAdminCapacity?: int|null,
 *   mediaKey?: string|null,
 *   mentionedUserIDs?: list<string>|null,
 *   tweetID?: string|null,
 *   tweet?: SearchTweet2|array<string,mixed>|null,
 *   creator?: UserProfile|array<string,mixed>|null,
 *   sharings?: list<SpaceSharing|array<string,mixed>>|null,
 * }
 */
final class Space implements BaseModel
{
    /** @use SdkModel<SpaceShape> */
    use SdkModel;

    /**
     * Space ID.
     */
    #[Required]
    public string $id;

    /**
     * Hosts and co-hosts.
     *
     * @var list<SpaceParticipant> $admins
     */
    #[Required(list: SpaceParticipant::class)]
    public array $admins;

    /**
     * Accounts X lists as speakers.
     *
     * @var list<SpaceParticipant> $speakers
     */
    #[Required(list: SpaceParticipant::class)]
    public array $speakers;

    /**
     * Accounts X lists as listeners.
     *
     * @var list<SpaceParticipant> $listeners
     */
    #[Required(list: SpaceParticipant::class)]
    public array $listeners;

    /**
     * Space title.
     */
    #[Optional]
    public ?string $title;

    /**
     * NotStarted (scheduled), Running (live), Ended, Canceled (scheduled, never started) or TimedOut (closed by X, not by its host).
     */
    #[Optional]
    public ?string $state;

    /**
     * When the Space was made.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAt;

    /**
     * When the Space was set to start.
     */
    #[Optional]
    public ?\DateTimeInterface $scheduledStart;

    /**
     * When the Space went live.
     */
    #[Optional]
    public ?\DateTimeInterface $startedAt;

    /**
     * When the Space ended.
     */
    #[Optional]
    public ?\DateTimeInterface $endedAt;

    /**
     * When X last changed the Space.
     */
    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * Accounts that listened live.
     */
    #[Optional]
    public ?int $totalLiveListeners;

    /**
     * Accounts that played the recording.
     */
    #[Optional]
    public ?int $totalReplayWatched;

    /**
     * Accounts in the Space now, while it is live.
     */
    #[Optional]
    public ?int $participantCount;

    /**
     * Whether X offers a recording.
     */
    #[Optional]
    public ?bool $isAvailableForReplay;

    /**
     * Whether listeners may clip the Space.
     */
    #[Optional]
    public ?bool $isAvailableForClipping;

    /**
     * Whether the host locked the Space.
     */
    #[Optional]
    public ?bool $isLocked;

    /**
     * Whether only X employees may join.
     */
    #[Optional]
    public ?bool $isEmployeeOnly;

    /**
     * Whether X lets no more accounts join.
     */
    #[Optional]
    public ?bool $disallowJoin;

    /**
     * Whether anonymous listening is off.
     */
    #[Optional]
    public ?bool $noIncognito;

    /**
     * Audio or video kind, as X names it.
     */
    #[Optional]
    public ?string $contentType;

    /**
     * X's code for who may speak.
     */
    #[Optional]
    public ?int $conversationControls;

    /**
     * Most hosts and co-hosts the Space allows.
     */
    #[Optional]
    public ?int $maxAdminCapacity;

    /**
     * X's media key for the Space's audio.
     */
    #[Optional]
    public ?string $mediaKey;

    /**
     * IDs of the accounts the host tagged.
     *
     * @var list<string>|null $mentionedUserIDs
     */
    #[Optional('mentionedUserIds', list: 'string')]
    public ?array $mentionedUserIDs;

    /**
     * ID of the post that announces the Space.
     */
    #[Optional('tweetId')]
    public ?string $tweetID;

    /**
     * Search tweet with author. Zero metrics may mean X omitted counts.
     */
    #[Optional]
    public ?SearchTweet2 $tweet;

    /**
     * Public X profile.
     */
    #[Optional]
    public ?UserProfile $creator;

    /**
     * Posts the hosts and speakers shared in the Space, in X's order. Present only when X lists them.
     *
     * @var list<SpaceSharing>|null $sharings
     */
    #[Optional(list: SpaceSharing::class)]
    public ?array $sharings;

    /**
     * `new Space()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Space::with(id: ..., admins: ..., speakers: ..., listeners: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Space)->withId(...)->withAdmins(...)->withSpeakers(...)->withListeners(...)
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
     * @param list<SpaceParticipant|array<string,mixed>> $admins
     * @param list<SpaceParticipant|array<string,mixed>> $speakers
     * @param list<SpaceParticipant|array<string,mixed>> $listeners
     * @param list<string>|null $mentionedUserIDs
     * @param SearchTweet2|array<string,mixed>|null $tweet
     * @param UserProfile|array<string,mixed>|null $creator
     * @param list<SpaceSharing|array<string,mixed>>|null $sharings
     */
    public static function with(string $id, array $admins, array $speakers, array $listeners, ?string $title = null, ?string $state = null, ?\DateTimeInterface $createdAt = null, ?\DateTimeInterface $scheduledStart = null, ?\DateTimeInterface $startedAt = null, ?\DateTimeInterface $endedAt = null, ?\DateTimeInterface $updatedAt = null, ?int $totalLiveListeners = null, ?int $totalReplayWatched = null, ?int $participantCount = null, ?bool $isAvailableForReplay = null, ?bool $isAvailableForClipping = null, ?bool $isLocked = null, ?bool $isEmployeeOnly = null, ?bool $disallowJoin = null, ?bool $noIncognito = null, ?string $contentType = null, ?int $conversationControls = null, ?int $maxAdminCapacity = null, ?string $mediaKey = null, ?array $mentionedUserIDs = null, ?string $tweetID = null, SearchTweet2|array|null $tweet = null, UserProfile|array|null $creator = null, ?array $sharings = null): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['admins'] = $admins;
        $self['speakers'] = $speakers;
        $self['listeners'] = $listeners;

        null !== $title && $self['title'] = $title;
        null !== $state && $self['state'] = $state;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $scheduledStart && $self['scheduledStart'] = $scheduledStart;
        null !== $startedAt && $self['startedAt'] = $startedAt;
        null !== $endedAt && $self['endedAt'] = $endedAt;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $totalLiveListeners && $self['totalLiveListeners'] = $totalLiveListeners;
        null !== $totalReplayWatched && $self['totalReplayWatched'] = $totalReplayWatched;
        null !== $participantCount && $self['participantCount'] = $participantCount;
        null !== $isAvailableForReplay && $self['isAvailableForReplay'] = $isAvailableForReplay;
        null !== $isAvailableForClipping && $self['isAvailableForClipping'] = $isAvailableForClipping;
        null !== $isLocked && $self['isLocked'] = $isLocked;
        null !== $isEmployeeOnly && $self['isEmployeeOnly'] = $isEmployeeOnly;
        null !== $disallowJoin && $self['disallowJoin'] = $disallowJoin;
        null !== $noIncognito && $self['noIncognito'] = $noIncognito;
        null !== $contentType && $self['contentType'] = $contentType;
        null !== $conversationControls && $self['conversationControls'] = $conversationControls;
        null !== $maxAdminCapacity && $self['maxAdminCapacity'] = $maxAdminCapacity;
        null !== $mediaKey && $self['mediaKey'] = $mediaKey;
        null !== $mentionedUserIDs && $self['mentionedUserIDs'] = $mentionedUserIDs;
        null !== $tweetID && $self['tweetID'] = $tweetID;
        null !== $tweet && $self['tweet'] = $tweet;
        null !== $creator && $self['creator'] = $creator;
        null !== $sharings && $self['sharings'] = $sharings;

        return $self;
    }

    /**
     * Space ID.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Hosts and co-hosts.
     *
     * @param list<SpaceParticipant|array<string,mixed>> $admins
     */
    public function withAdmins(array $admins): self
    {
        $self = clone $this;
        $self['admins'] = $admins;

        return $self;
    }

    /**
     * Accounts X lists as speakers.
     *
     * @param list<SpaceParticipant|array<string,mixed>> $speakers
     */
    public function withSpeakers(array $speakers): self
    {
        $self = clone $this;
        $self['speakers'] = $speakers;

        return $self;
    }

    /**
     * Accounts X lists as listeners.
     *
     * @param list<SpaceParticipant|array<string,mixed>> $listeners
     */
    public function withListeners(array $listeners): self
    {
        $self = clone $this;
        $self['listeners'] = $listeners;

        return $self;
    }

    /**
     * Space title.
     */
    public function withTitle(?string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    /**
     * NotStarted (scheduled), Running (live), Ended, Canceled (scheduled, never started) or TimedOut (closed by X, not by its host).
     */
    public function withState(?string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }

    /**
     * When the Space was made.
     */
    public function withCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * When the Space was set to start.
     */
    public function withScheduledStart(?\DateTimeInterface $scheduledStart): self
    {
        $self = clone $this;
        $self['scheduledStart'] = $scheduledStart;

        return $self;
    }

    /**
     * When the Space went live.
     */
    public function withStartedAt(?\DateTimeInterface $startedAt): self
    {
        $self = clone $this;
        $self['startedAt'] = $startedAt;

        return $self;
    }

    /**
     * When the Space ended.
     */
    public function withEndedAt(?\DateTimeInterface $endedAt): self
    {
        $self = clone $this;
        $self['endedAt'] = $endedAt;

        return $self;
    }

    /**
     * When X last changed the Space.
     */
    public function withUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Accounts that listened live.
     */
    public function withTotalLiveListeners(?int $totalLiveListeners): self
    {
        $self = clone $this;
        $self['totalLiveListeners'] = $totalLiveListeners;

        return $self;
    }

    /**
     * Accounts that played the recording.
     */
    public function withTotalReplayWatched(?int $totalReplayWatched): self
    {
        $self = clone $this;
        $self['totalReplayWatched'] = $totalReplayWatched;

        return $self;
    }

    /**
     * Accounts in the Space now, while it is live.
     */
    public function withParticipantCount(?int $participantCount): self
    {
        $self = clone $this;
        $self['participantCount'] = $participantCount;

        return $self;
    }

    /**
     * Whether X offers a recording.
     */
    public function withIsAvailableForReplay(?bool $isAvailableForReplay): self
    {
        $self = clone $this;
        $self['isAvailableForReplay'] = $isAvailableForReplay;

        return $self;
    }

    /**
     * Whether listeners may clip the Space.
     */
    public function withIsAvailableForClipping(?bool $isAvailableForClipping): self
    {
        $self = clone $this;
        $self['isAvailableForClipping'] = $isAvailableForClipping;

        return $self;
    }

    /**
     * Whether the host locked the Space.
     */
    public function withIsLocked(?bool $isLocked): self
    {
        $self = clone $this;
        $self['isLocked'] = $isLocked;

        return $self;
    }

    /**
     * Whether only X employees may join.
     */
    public function withIsEmployeeOnly(?bool $isEmployeeOnly): self
    {
        $self = clone $this;
        $self['isEmployeeOnly'] = $isEmployeeOnly;

        return $self;
    }

    /**
     * Whether X lets no more accounts join.
     */
    public function withDisallowJoin(?bool $disallowJoin): self
    {
        $self = clone $this;
        $self['disallowJoin'] = $disallowJoin;

        return $self;
    }

    /**
     * Whether anonymous listening is off.
     */
    public function withNoIncognito(?bool $noIncognito): self
    {
        $self = clone $this;
        $self['noIncognito'] = $noIncognito;

        return $self;
    }

    /**
     * Audio or video kind, as X names it.
     */
    public function withContentType(?string $contentType): self
    {
        $self = clone $this;
        $self['contentType'] = $contentType;

        return $self;
    }

    /**
     * X's code for who may speak.
     */
    public function withConversationControls(?int $conversationControls): self
    {
        $self = clone $this;
        $self['conversationControls'] = $conversationControls;

        return $self;
    }

    /**
     * Most hosts and co-hosts the Space allows.
     */
    public function withMaxAdminCapacity(?int $maxAdminCapacity): self
    {
        $self = clone $this;
        $self['maxAdminCapacity'] = $maxAdminCapacity;

        return $self;
    }

    /**
     * X's media key for the Space's audio.
     */
    public function withMediaKey(?string $mediaKey): self
    {
        $self = clone $this;
        $self['mediaKey'] = $mediaKey;

        return $self;
    }

    /**
     * IDs of the accounts the host tagged.
     *
     * @param list<string>|null $mentionedUserIDs
     */
    public function withMentionedUserIDs(?array $mentionedUserIDs): self
    {
        $self = clone $this;
        $self['mentionedUserIDs'] = $mentionedUserIDs;

        return $self;
    }

    /**
     * ID of the post that announces the Space.
     */
    public function withTweetID(?string $tweetID): self
    {
        $self = clone $this;
        $self['tweetID'] = $tweetID;

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

    /**
     * Public X profile.
     *
     * @param UserProfile|array<string,mixed>|null $creator
     */
    public function withCreator(UserProfile|array|null $creator): self
    {
        $self = clone $this;
        $self['creator'] = $creator;

        return $self;
    }

    /**
     * Posts the hosts and speakers shared in the Space, in X's order. Present only when X lists them.
     *
     * @param list<SpaceSharing|array<string,mixed>>|null $sharings
     */
    public function withSharings(?array $sharings): self
    {
        $self = clone $this;
        $self['sharings'] = $sharings;

        return $self;
    }
}
