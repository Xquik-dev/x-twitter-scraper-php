<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Monitors\Posts;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\PostEventType;

/**
 * Creates a monitor for 1 X post. It tracks replies, quotes, edits, deletion & 6 metrics, for 30 credits an hour with events & webhook deliveries included. That hourly price is a monitor's only charge. Creation needs the credits of the first hour & reads the post once.
 *
 * @see XTwitterScraper\Services\Monitors\PostsService::create()
 *
 * @phpstan-type PostCreateParamsShape = array{
 *   post: string,
 *   name?: string|null,
 *   eventTypes?: list<PostEventType|value-of<PostEventType>>|null,
 *   isActive?: bool|null,
 * }
 */
final class PostCreateParams implements BaseModel
{
    /** @use SdkModel<PostCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Post link or ID. x.com, twitter.com, mobile & /i/web/status/ links work with any query string.
     */
    #[Required]
    public string $post;

    /**
     * Your own label for the post monitor. Its events carry it as monitorName.
     */
    #[Optional(nullable: true)]
    public ?string $name;

    /**
     * Post event types to send. Without it, a monitor sends new replies, new quotes, like & retweet changes, edits & deletion.
     *
     * @var list<value-of<PostEventType>>|null $eventTypes
     */
    #[Optional(list: PostEventType::class)]
    public ?array $eventTypes;

    /**
     * Send false to create the monitor paused. A paused monitor reads nothing & costs nothing until a PATCH sets isActive to true.
     */
    #[Optional]
    public ?bool $isActive;

    /**
     * `new PostCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PostCreateParams::with(post: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PostCreateParams)->withPost(...)
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
     * @param list<PostEventType|value-of<PostEventType>>|null $eventTypes
     */
    public static function with(string $post, ?string $name = null, ?array $eventTypes = null, ?bool $isActive = null): self
    {
        $self = new self;

        $self['post'] = $post;

        null !== $name && $self['name'] = $name;
        null !== $eventTypes && $self['eventTypes'] = $eventTypes;
        null !== $isActive && $self['isActive'] = $isActive;

        return $self;
    }

    /**
     * Post link or ID. x.com, twitter.com, mobile & /i/web/status/ links work with any query string.
     */
    public function withPost(string $post): self
    {
        $self = clone $this;
        $self['post'] = $post;

        return $self;
    }

    /**
     * Your own label for the post monitor. Its events carry it as monitorName.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Post event types to send. Without it, a monitor sends new replies, new quotes, like & retweet changes, edits & deletion.
     *
     * @param list<PostEventType|value-of<PostEventType>>|null $eventTypes
     */
    public function withEventTypes(?array $eventTypes): self
    {
        $self = clone $this;
        $self['eventTypes'] = $eventTypes;

        return $self;
    }

    /**
     * Send false to create the monitor paused. A paused monitor reads nothing & costs nothing until a PATCH sets isActive to true.
     */
    public function withIsActive(?bool $isActive): self
    {
        $self = clone $this;
        $self['isActive'] = $isActive;

        return $self;
    }
}
