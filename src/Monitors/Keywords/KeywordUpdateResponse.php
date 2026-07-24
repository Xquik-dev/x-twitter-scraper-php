<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Monitors\Keywords;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\EventType;

/**
 * Keyword monitor that tracks matching public X activity.
 *
 * @phpstan-type KeywordUpdateResponseShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   eventTypes: list<EventType|value-of<EventType>>,
 *   isActive: bool,
 *   nextBillingAt: \DateTimeInterface,
 *   query: string,
 * }
 */
final class KeywordUpdateResponse implements BaseModel
{
    /** @use SdkModel<KeywordUpdateResponseShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    /**
     * Array of event types to subscribe to.
     *
     * @var list<value-of<EventType>> $eventTypes
     */
    #[Required(list: EventType::class)]
    public array $eventTypes;

    #[Required]
    public bool $isActive;

    /**
     * Next hourly credit charge time for this keyword query monitor.
     */
    #[Required]
    public \DateTimeInterface $nextBillingAt;

    #[Required]
    public string $query;

    /**
     * `new KeywordUpdateResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * KeywordUpdateResponse::with(
     *   id: ...,
     *   createdAt: ...,
     *   eventTypes: ...,
     *   isActive: ...,
     *   nextBillingAt: ...,
     *   query: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new KeywordUpdateResponse)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withEventTypes(...)
     *   ->withIsActive(...)
     *   ->withNextBillingAt(...)
     *   ->withQuery(...)
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
     * @param list<EventType|value-of<EventType>> $eventTypes
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        array $eventTypes,
        bool $isActive,
        \DateTimeInterface $nextBillingAt,
        string $query,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['eventTypes'] = $eventTypes;
        $self['isActive'] = $isActive;
        $self['nextBillingAt'] = $nextBillingAt;
        $self['query'] = $query;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Array of event types to subscribe to.
     *
     * @param list<EventType|value-of<EventType>> $eventTypes
     */
    public function withEventTypes(array $eventTypes): self
    {
        $self = clone $this;
        $self['eventTypes'] = $eventTypes;

        return $self;
    }

    public function withIsActive(bool $isActive): self
    {
        $self = clone $this;
        $self['isActive'] = $isActive;

        return $self;
    }

    /**
     * Next hourly credit charge time for this keyword query monitor.
     */
    public function withNextBillingAt(\DateTimeInterface $nextBillingAt): self
    {
        $self = clone $this;
        $self['nextBillingAt'] = $nextBillingAt;

        return $self;
    }

    public function withQuery(string $query): self
    {
        $self = clone $this;
        $self['query'] = $query;

        return $self;
    }
}
