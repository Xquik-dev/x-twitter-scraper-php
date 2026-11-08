<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Broadcast\PeriscopeUser;
use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type BroadcastShape = array{
 *   id: string,
 *   title?: string|null,
 *   isTitleEdited?: bool|null,
 *   state?: string|null,
 *   scheduledStart?: \DateTimeInterface|null,
 *   startedAt?: \DateTimeInterface|null,
 *   endedAt?: \DateTimeInterface|null,
 *   lastPingAt?: \DateTimeInterface|null,
 *   totalWatched?: int|null,
 *   totalWatching?: int|null,
 *   isAvailableForReplay?: bool|null,
 *   width?: int|null,
 *   height?: int|null,
 *   cameraRotation?: int|null,
 *   isHighLatency?: bool|null,
 *   chatOption?: int|null,
 *   isPrivateChat?: bool|null,
 *   source?: string|null,
 *   mediaKey?: string|null,
 *   preLiveSlateUrl?: string|null,
 *   version?: int|null,
 *   tweetID?: string|null,
 *   tweet?: SearchTweet2|array<string,mixed>|null,
 *   periscopeUser?: PeriscopeUser|array<string,mixed>|null,
 *   creator?: UserProfile|array<string,mixed>|null,
 * }
 */
final class Broadcast implements BaseModel
{
    /** @use SdkModel<BroadcastShape> */
    use SdkModel;

    /**
     * Broadcast ID.
     */
    #[Required]
    public string $id;

    /**
     * Broadcast title.
     */
    #[Optional]
    public ?string $title;

    /**
     * Whether the broadcaster edited the title of the replay.
     */
    #[Optional]
    public ?bool $isTitleEdited;

    /**
     * State, such as NotStarted, Running or Ended, as X names it.
     */
    #[Optional]
    public ?string $state;

    /**
     * When the broadcast was set to start.
     */
    #[Optional]
    public ?\DateTimeInterface $scheduledStart;

    /**
     * When the broadcast went live.
     */
    #[Optional]
    public ?\DateTimeInterface $startedAt;

    /**
     * When the broadcast ended.
     */
    #[Optional]
    public ?\DateTimeInterface $endedAt;

    /**
     * When the video stream last reached X.
     */
    #[Optional]
    public ?\DateTimeInterface $lastPingAt;

    /**
     * Accounts that watched, live or after.
     */
    #[Optional]
    public ?int $totalWatched;

    /**
     * Accounts watching, as X counts them.
     */
    #[Optional]
    public ?int $totalWatching;

    /**
     * Whether X offers a recording of the broadcast.
     */
    #[Optional]
    public ?bool $isAvailableForReplay;

    /**
     * Video width in pixels.
     */
    #[Optional]
    public ?int $width;

    /**
     * Video height in pixels.
     */
    #[Optional]
    public ?int $height;

    /**
     * Camera rotation in degrees.
     */
    #[Optional]
    public ?int $cameraRotation;

    /**
     * Whether the video stream runs in high-latency mode.
     */
    #[Optional]
    public ?bool $isHighLatency;

    /**
     * X's code for who may chat.
     */
    #[Optional]
    public ?int $chatOption;

    /**
     * Whether X marks the chat private.
     */
    #[Optional]
    public ?bool $isPrivateChat;

    /**
     * What produced the video stream, as X names it.
     */
    #[Optional]
    public ?string $source;

    /**
     * X's media key for the video.
     */
    #[Optional]
    public ?string $mediaKey;

    /**
     * Image X shows before the broadcast starts.
     */
    #[Optional]
    public ?string $preLiveSlateUrl;

    /**
     * X's revision number of the broadcast.
     */
    #[Optional]
    public ?int $version;

    /**
     * ID of the post that announces the broadcast.
     */
    #[Optional('tweetId')]
    public ?string $tweetID;

    /**
     * Search tweet with author. Zero metrics may mean X omitted counts.
     */
    #[Optional]
    public ?SearchTweet2 $tweet;

    /**
     * Broadcaster, as X's live video service names the account.
     */
    #[Optional]
    public ?PeriscopeUser $periscopeUser;

    /**
     * Public X profile.
     */
    #[Optional]
    public ?UserProfile $creator;

    /**
     * `new Broadcast()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Broadcast::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Broadcast)->withId(...)
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
     * @param SearchTweet2|array<string,mixed>|null $tweet
     * @param PeriscopeUser|array<string,mixed>|null $periscopeUser
     * @param UserProfile|array<string,mixed>|null $creator
     */
    public static function with(string $id, ?string $title = null, ?bool $isTitleEdited = null, ?string $state = null, ?\DateTimeInterface $scheduledStart = null, ?\DateTimeInterface $startedAt = null, ?\DateTimeInterface $endedAt = null, ?\DateTimeInterface $lastPingAt = null, ?int $totalWatched = null, ?int $totalWatching = null, ?bool $isAvailableForReplay = null, ?int $width = null, ?int $height = null, ?int $cameraRotation = null, ?bool $isHighLatency = null, ?int $chatOption = null, ?bool $isPrivateChat = null, ?string $source = null, ?string $mediaKey = null, ?string $preLiveSlateUrl = null, ?int $version = null, ?string $tweetID = null, SearchTweet2|array|null $tweet = null, PeriscopeUser|array|null $periscopeUser = null, UserProfile|array|null $creator = null): self
    {
        $self = new self;

        $self['id'] = $id;

        null !== $title && $self['title'] = $title;
        null !== $isTitleEdited && $self['isTitleEdited'] = $isTitleEdited;
        null !== $state && $self['state'] = $state;
        null !== $scheduledStart && $self['scheduledStart'] = $scheduledStart;
        null !== $startedAt && $self['startedAt'] = $startedAt;
        null !== $endedAt && $self['endedAt'] = $endedAt;
        null !== $lastPingAt && $self['lastPingAt'] = $lastPingAt;
        null !== $totalWatched && $self['totalWatched'] = $totalWatched;
        null !== $totalWatching && $self['totalWatching'] = $totalWatching;
        null !== $isAvailableForReplay && $self['isAvailableForReplay'] = $isAvailableForReplay;
        null !== $width && $self['width'] = $width;
        null !== $height && $self['height'] = $height;
        null !== $cameraRotation && $self['cameraRotation'] = $cameraRotation;
        null !== $isHighLatency && $self['isHighLatency'] = $isHighLatency;
        null !== $chatOption && $self['chatOption'] = $chatOption;
        null !== $isPrivateChat && $self['isPrivateChat'] = $isPrivateChat;
        null !== $source && $self['source'] = $source;
        null !== $mediaKey && $self['mediaKey'] = $mediaKey;
        null !== $preLiveSlateUrl && $self['preLiveSlateUrl'] = $preLiveSlateUrl;
        null !== $version && $self['version'] = $version;
        null !== $tweetID && $self['tweetID'] = $tweetID;
        null !== $tweet && $self['tweet'] = $tweet;
        null !== $periscopeUser && $self['periscopeUser'] = $periscopeUser;
        null !== $creator && $self['creator'] = $creator;

        return $self;
    }

    /**
     * Broadcast ID.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Broadcast title.
     */
    public function withTitle(?string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    /**
     * Whether the broadcaster edited the title of the replay.
     */
    public function withIsTitleEdited(?bool $isTitleEdited): self
    {
        $self = clone $this;
        $self['isTitleEdited'] = $isTitleEdited;

        return $self;
    }

    /**
     * State, such as NotStarted, Running or Ended, as X names it.
     */
    public function withState(?string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }

    /**
     * When the broadcast was set to start.
     */
    public function withScheduledStart(?\DateTimeInterface $scheduledStart): self
    {
        $self = clone $this;
        $self['scheduledStart'] = $scheduledStart;

        return $self;
    }

    /**
     * When the broadcast went live.
     */
    public function withStartedAt(?\DateTimeInterface $startedAt): self
    {
        $self = clone $this;
        $self['startedAt'] = $startedAt;

        return $self;
    }

    /**
     * When the broadcast ended.
     */
    public function withEndedAt(?\DateTimeInterface $endedAt): self
    {
        $self = clone $this;
        $self['endedAt'] = $endedAt;

        return $self;
    }

    /**
     * When the video stream last reached X.
     */
    public function withLastPingAt(?\DateTimeInterface $lastPingAt): self
    {
        $self = clone $this;
        $self['lastPingAt'] = $lastPingAt;

        return $self;
    }

    /**
     * Accounts that watched, live or after.
     */
    public function withTotalWatched(?int $totalWatched): self
    {
        $self = clone $this;
        $self['totalWatched'] = $totalWatched;

        return $self;
    }

    /**
     * Accounts watching, as X counts them.
     */
    public function withTotalWatching(?int $totalWatching): self
    {
        $self = clone $this;
        $self['totalWatching'] = $totalWatching;

        return $self;
    }

    /**
     * Whether X offers a recording of the broadcast.
     */
    public function withIsAvailableForReplay(?bool $isAvailableForReplay): self
    {
        $self = clone $this;
        $self['isAvailableForReplay'] = $isAvailableForReplay;

        return $self;
    }

    /**
     * Video width in pixels.
     */
    public function withWidth(?int $width): self
    {
        $self = clone $this;
        $self['width'] = $width;

        return $self;
    }

    /**
     * Video height in pixels.
     */
    public function withHeight(?int $height): self
    {
        $self = clone $this;
        $self['height'] = $height;

        return $self;
    }

    /**
     * Camera rotation in degrees.
     */
    public function withCameraRotation(?int $cameraRotation): self
    {
        $self = clone $this;
        $self['cameraRotation'] = $cameraRotation;

        return $self;
    }

    /**
     * Whether the video stream runs in high-latency mode.
     */
    public function withIsHighLatency(?bool $isHighLatency): self
    {
        $self = clone $this;
        $self['isHighLatency'] = $isHighLatency;

        return $self;
    }

    /**
     * X's code for who may chat.
     */
    public function withChatOption(?int $chatOption): self
    {
        $self = clone $this;
        $self['chatOption'] = $chatOption;

        return $self;
    }

    /**
     * Whether X marks the chat private.
     */
    public function withIsPrivateChat(?bool $isPrivateChat): self
    {
        $self = clone $this;
        $self['isPrivateChat'] = $isPrivateChat;

        return $self;
    }

    /**
     * What produced the video stream, as X names it.
     */
    public function withSource(?string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    /**
     * X's media key for the video.
     */
    public function withMediaKey(?string $mediaKey): self
    {
        $self = clone $this;
        $self['mediaKey'] = $mediaKey;

        return $self;
    }

    /**
     * Image X shows before the broadcast starts.
     */
    public function withPreLiveSlateUrl(?string $preLiveSlateUrl): self
    {
        $self = clone $this;
        $self['preLiveSlateUrl'] = $preLiveSlateUrl;

        return $self;
    }

    /**
     * X's revision number of the broadcast.
     */
    public function withVersion(?int $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

        return $self;
    }

    /**
     * ID of the post that announces the broadcast.
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
     * Broadcaster, as X's live video service names the account.
     *
     * @param PeriscopeUser|array<string,mixed>|null $periscopeUser
     */
    public function withPeriscopeUser(PeriscopeUser|array|null $periscopeUser): self
    {
        $self = clone $this;
        $self['periscopeUser'] = $periscopeUser;

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
}
