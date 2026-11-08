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
 * Updates a post monitor's label, event types or active state. Turning a paused monitor on reads the post first, & answers 409 while X hides it.
 *
 * @see XTwitterScraper\Services\Monitors\PostsService::update()
 *
 * @phpstan-type PostUpdateParamsShape = array{
 *   eventTypes?: list<PostEventType|value-of<PostEventType>>|null,
 *   isActive?: bool|null,
 *   name?: string|null,
 * }
 */
final class PostUpdateParams implements BaseModel
{
    /** @use SdkModel<PostUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Post event types to send. Without it, a monitor sends new replies, new quotes, like & retweet changes, edits & deletion.
     *
     * @var list<value-of<PostEventType>>|null $eventTypes
     */
    #[Optional(list: PostEventType::class)]
    public ?array $eventTypes;

    #[Optional]
    public ?bool $isActive;

    /**
     * New label for the post monitor. Send null to remove it.
     */
    #[Optional(nullable: true)]
    public ?string $name;

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
    public static function with(?array $eventTypes = null, ?bool $isActive = null, ?string $name = null): self
    {
        $self = new self;

        null !== $eventTypes && $self['eventTypes'] = $eventTypes;
        null !== $isActive && $self['isActive'] = $isActive;
        null !== $name && $self['name'] = $name;

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

    public function withIsActive(?bool $isActive): self
    {
        $self = clone $this;
        $self['isActive'] = $isActive;

        return $self;
    }

    /**
     * New label for the post monitor. Send null to remove it.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
