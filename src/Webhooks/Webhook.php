<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Webhooks;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\EventType;
use XTwitterScraper\Webhooks\Webhook\DeliveryStatus;

/**
 * Webhook endpoint registered to receive event deliveries.
 *
 * @phpstan-type WebhookShape = array{
 *   id: string,
 *   consecutiveFailures: int,
 *   createdAt: \DateTimeInterface,
 *   deliveryStatus: DeliveryStatus|value-of<DeliveryStatus>,
 *   eventTypes: list<EventType|value-of<EventType>>,
 *   failureHardCap: int,
 *   isActive: bool,
 *   url: string,
 * }
 */
final class Webhook implements BaseModel
{
    /** @use SdkModel<WebhookShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /**
     * Consecutive failed delivery attempts since the last success.
     */
    #[Required]
    public int $consecutiveFailures;

    #[Required]
    public \DateTimeInterface $createdAt;

    /**
     * Endpoint delivery state. needs_attention means delivery stopped after repeated failures.
     *
     * @var value-of<DeliveryStatus> $deliveryStatus
     */
    #[Required(enum: DeliveryStatus::class)]
    public string $deliveryStatus;

    /**
     * Array of event types to subscribe to.
     *
     * @var list<value-of<EventType>> $eventTypes
     */
    #[Required(list: EventType::class)]
    public array $eventTypes;

    /**
     * Consecutive delivery failures that pause the endpoint.
     */
    #[Required]
    public int $failureHardCap;

    #[Required]
    public bool $isActive;

    #[Required]
    public string $url;

    /**
     * `new Webhook()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Webhook::with(
     *   id: ...,
     *   consecutiveFailures: ...,
     *   createdAt: ...,
     *   deliveryStatus: ...,
     *   eventTypes: ...,
     *   failureHardCap: ...,
     *   isActive: ...,
     *   url: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Webhook)
     *   ->withID(...)
     *   ->withConsecutiveFailures(...)
     *   ->withCreatedAt(...)
     *   ->withDeliveryStatus(...)
     *   ->withEventTypes(...)
     *   ->withFailureHardCap(...)
     *   ->withIsActive(...)
     *   ->withURL(...)
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
     * @param DeliveryStatus|value-of<DeliveryStatus> $deliveryStatus
     * @param list<EventType|value-of<EventType>> $eventTypes
     */
    public static function with(
        string $id,
        int $consecutiveFailures,
        \DateTimeInterface $createdAt,
        DeliveryStatus|string $deliveryStatus,
        array $eventTypes,
        int $failureHardCap,
        bool $isActive,
        string $url,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['consecutiveFailures'] = $consecutiveFailures;
        $self['createdAt'] = $createdAt;
        $self['deliveryStatus'] = $deliveryStatus;
        $self['eventTypes'] = $eventTypes;
        $self['failureHardCap'] = $failureHardCap;
        $self['isActive'] = $isActive;
        $self['url'] = $url;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Consecutive failed delivery attempts since the last success.
     */
    public function withConsecutiveFailures(int $consecutiveFailures): self
    {
        $self = clone $this;
        $self['consecutiveFailures'] = $consecutiveFailures;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Endpoint delivery state. needs_attention means delivery stopped after repeated failures.
     *
     * @param DeliveryStatus|value-of<DeliveryStatus> $deliveryStatus
     */
    public function withDeliveryStatus(
        DeliveryStatus|string $deliveryStatus
    ): self {
        $self = clone $this;
        $self['deliveryStatus'] = $deliveryStatus;

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

    /**
     * Consecutive delivery failures that pause the endpoint.
     */
    public function withFailureHardCap(int $failureHardCap): self
    {
        $self = clone $this;
        $self['failureHardCap'] = $failureHardCap;

        return $self;
    }

    public function withIsActive(bool $isActive): self
    {
        $self = clone $this;
        $self['isActive'] = $isActive;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
