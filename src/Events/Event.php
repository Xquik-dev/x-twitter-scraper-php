<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Events;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Events\Event\MonitorType;
use XTwitterScraper\EventType;

/**
 * Monitor event summary with source metadata and occurrence time.
 *
 * @phpstan-type EventShape = array{
 *   id: string,
 *   data: array<string,mixed>,
 *   monitorID: string,
 *   monitorType: MonitorType|value-of<MonitorType>,
 *   occurredAt: \DateTimeInterface,
 *   type: EventType|value-of<EventType>,
 *   keywordMonitorID?: string|null,
 *   query?: string|null,
 *   username?: string|null,
 *   xUserID?: string|null,
 *   monitorName?: string|null,
 *   postID?: string|null,
 *   postUrl?: string|null,
 *   authorID?: string|null,
 *   authorUsername?: string|null,
 * }
 */
final class Event implements BaseModel
{
    /** @use SdkModel<EventShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /** @var array<string,mixed> $data */
    #[Required(map: 'mixed')]
    public array $data;

    /**
     * Account monitor ID for account events, or keyword monitor ID for keyword events.
     */
    #[Required('monitorId')]
    public string $monitorID;

    /**
     * Source monitor type.
     *
     * @var value-of<MonitorType> $monitorType
     */
    #[Required(enum: MonitorType::class)]
    public string $monitorType;

    #[Required]
    public \DateTimeInterface $occurredAt;

    /**
     * Type of monitor event fired when account activity occurs.
     *
     * @var value-of<EventType> $type
     */
    #[Required(enum: EventType::class)]
    public string $type;

    /**
     * Keyword monitor ID, present for keyword monitor events.
     */
    #[Optional('keywordMonitorId')]
    public ?string $keywordMonitorID;

    /**
     * Keyword query, present for keyword monitor events.
     */
    #[Optional]
    public ?string $query;

    /**
     * Account username, present for account monitor events.
     */
    #[Optional]
    public ?string $username;

    /**
     * Permanent X user ID of the monitored account, present for account monitor events. It stays the same after a username change.
     */
    #[Optional('xUserId')]
    public ?string $xUserID;

    /**
     * Your monitor label when Xquik created the event, present when set. A rename leaves the event's label unchanged.
     */
    #[Optional]
    public ?string $monitorName;

    /**
     * ID of the monitored post, present for post events.
     */
    #[Optional('postId')]
    public ?string $postID;

    /**
     * Link to the monitored post, present for post events.
     */
    #[Optional]
    public ?string $postUrl;

    /**
     * Permanent X user ID of the monitored post's author, present for post events.
     */
    #[Optional('authorId')]
    public ?string $authorID;

    /**
     * Username of the monitored post's author, present for post events.
     */
    #[Optional]
    public ?string $authorUsername;

    /**
     * `new Event()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Event::with(
     *   id: ...,
     *   data: ...,
     *   monitorID: ...,
     *   monitorType: ...,
     *   occurredAt: ...,
     *   type: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Event)
     *   ->withID(...)
     *   ->withData(...)
     *   ->withMonitorID(...)
     *   ->withMonitorType(...)
     *   ->withOccurredAt(...)
     *   ->withType(...)
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
     * @param array<string,mixed> $data
     * @param MonitorType|value-of<MonitorType> $monitorType
     * @param EventType|value-of<EventType> $type
     */
    public static function with(
        string $id,
        array $data,
        string $monitorID,
        MonitorType|string $monitorType,
        \DateTimeInterface $occurredAt,
        EventType|string $type,
        ?string $keywordMonitorID = null,
        ?string $query = null,
        ?string $username = null,
        ?string $xUserID = null,
        ?string $monitorName = null,
        ?string $postID = null,
        ?string $postUrl = null,
        ?string $authorID = null,
        ?string $authorUsername = null
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['data'] = $data;
        $self['monitorID'] = $monitorID;
        $self['monitorType'] = $monitorType;
        $self['occurredAt'] = $occurredAt;
        $self['type'] = $type;

        null !== $keywordMonitorID && $self['keywordMonitorID'] = $keywordMonitorID;
        null !== $query && $self['query'] = $query;
        null !== $username && $self['username'] = $username;

        null !== $xUserID && $self['xUserID'] = $xUserID;

        null !== $monitorName && $self['monitorName'] = $monitorName;

        null !== $postID && $self['postID'] = $postID;

        null !== $postUrl && $self['postUrl'] = $postUrl;

        null !== $authorID && $self['authorID'] = $authorID;

        null !== $authorUsername && $self['authorUsername'] = $authorUsername;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param array<string,mixed> $data
     */
    public function withData(array $data): self
    {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }

    /**
     * Account monitor ID for account events, or keyword monitor ID for keyword events.
     */
    public function withMonitorID(string $monitorID): self
    {
        $self = clone $this;
        $self['monitorID'] = $monitorID;

        return $self;
    }

    /**
     * Source monitor type.
     *
     * @param MonitorType|value-of<MonitorType> $monitorType
     */
    public function withMonitorType(MonitorType|string $monitorType): self
    {
        $self = clone $this;
        $self['monitorType'] = $monitorType;

        return $self;
    }

    public function withOccurredAt(\DateTimeInterface $occurredAt): self
    {
        $self = clone $this;
        $self['occurredAt'] = $occurredAt;

        return $self;
    }

    /**
     * Type of monitor event fired when account activity occurs.
     *
     * @param EventType|value-of<EventType> $type
     */
    public function withType(EventType|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Keyword monitor ID, present for keyword monitor events.
     */
    public function withKeywordMonitorID(string $keywordMonitorID): self
    {
        $self = clone $this;
        $self['keywordMonitorID'] = $keywordMonitorID;

        return $self;
    }

    /**
     * Keyword query, present for keyword monitor events.
     */
    public function withQuery(string $query): self
    {
        $self = clone $this;
        $self['query'] = $query;

        return $self;
    }

    /**
     * Account username, present for account monitor events.
     */
    public function withUsername(string $username): self
    {
        $self = clone $this;
        $self['username'] = $username;

        return $self;
    }

    /**
     * Permanent X user ID of the monitored account, present for account monitor events. It stays the same after a username change.
     */
    public function withXUserID(?string $xUserID): self
    {
        $self = clone $this;
        $self['xUserID'] = $xUserID;

        return $self;
    }

    /**
     * Your monitor label when Xquik created the event, present when set. A rename leaves the event's label unchanged.
     */
    public function withMonitorName(?string $monitorName): self
    {
        $self = clone $this;
        $self['monitorName'] = $monitorName;

        return $self;
    }

    /**
     * ID of the monitored post, present for post events.
     */
    public function withPostID(?string $postID): self
    {
        $self = clone $this;
        $self['postID'] = $postID;

        return $self;
    }

    /**
     * Link to the monitored post, present for post events.
     */
    public function withPostUrl(?string $postUrl): self
    {
        $self = clone $this;
        $self['postUrl'] = $postUrl;

        return $self;
    }

    /**
     * Permanent X user ID of the monitored post's author, present for post events.
     */
    public function withAuthorID(?string $authorID): self
    {
        $self = clone $this;
        $self['authorID'] = $authorID;

        return $self;
    }

    /**
     * Username of the monitored post's author, present for post events.
     */
    public function withAuthorUsername(?string $authorUsername): self
    {
        $self = clone $this;
        $self['authorUsername'] = $authorUsername;

        return $self;
    }
}
