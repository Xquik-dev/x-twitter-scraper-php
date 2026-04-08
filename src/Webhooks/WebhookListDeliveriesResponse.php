<?php

declare(strict_types=1);

namespace XTwitterScraper\Webhooks;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type DeliveryShape from \XTwitterScraper\Webhooks\Delivery
 *
 * @phpstan-type WebhookListDeliveriesResponseShape = array{
 *   deliveries: list<Delivery|DeliveryShape>
 * }
 */
final class WebhookListDeliveriesResponse implements BaseModel
{
    /** @use SdkModel<WebhookListDeliveriesResponseShape> */
    use SdkModel;

    /** @var list<Delivery> $deliveries */
    #[Required(list: Delivery::class)]
    public array $deliveries;

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
    public static function with(array $deliveries): self
    {
        $self = new self;

        $self['deliveries'] = $deliveries;

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
}
