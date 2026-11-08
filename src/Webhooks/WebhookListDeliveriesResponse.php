<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Webhooks;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type DeliveryShape from Delivery
 *
 * @phpstan-type WebhookListDeliveriesResponseShape = array{
 *   deliveries: list<Delivery|DeliveryShape>,
 *   hasMore?: bool|null,
 *   nextCursor?: string|null,
 * }
 */
final class WebhookListDeliveriesResponse implements BaseModel
{
    /** @use SdkModel<WebhookListDeliveriesResponseShape> */
    use SdkModel;

    /** @var list<Delivery> $deliveries */
    #[Required(list: Delivery::class)]
    public array $deliveries;

    #[Optional]
    public ?bool $hasMore;

    #[Optional]
    public ?string $nextCursor;

    /**
     * `new WebhookListDeliveriesResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebhookListDeliveriesResponse::with(deliveries: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebhookListDeliveriesResponse)->withDeliveries(...)
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
     * @param list<Delivery|DeliveryShape> $deliveries
     */
    public static function with(array $deliveries, ?bool $hasMore = null, ?string $nextCursor = null): self
    {
        $self = new self;

        $self['deliveries'] = $deliveries;

        null !== $hasMore && $self['hasMore'] = $hasMore;

        null !== $nextCursor && $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * @param list<Delivery|DeliveryShape> $deliveries
     */
    public function withDeliveries(array $deliveries): self
    {
        $self = clone $this;
        $self['deliveries'] = $deliveries;

        return $self;
    }

    public function withHasMore(?bool $hasMore): self
    {
        $self = clone $this;
        $self['hasMore'] = $hasMore;

        return $self;
    }

    public function withNextCursor(?string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }
}
