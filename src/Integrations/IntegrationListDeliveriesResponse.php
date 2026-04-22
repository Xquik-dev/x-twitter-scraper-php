<?php

declare(strict_types=1);

namespace XTwitterScraper\Integrations;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type IntegrationDeliveryShape from \XTwitterScraper\Integrations\IntegrationDelivery
 *
 * @phpstan-type IntegrationListDeliveriesResponseShape = array{
 *   deliveries: list<IntegrationDelivery|IntegrationDeliveryShape>
 * }
 */
final class IntegrationListDeliveriesResponse implements BaseModel
{
    /** @use SdkModel<IntegrationListDeliveriesResponseShape> */
    use SdkModel;

    /** @var list<IntegrationDelivery> $deliveries */
    #[Required(list: IntegrationDelivery::class)]
    public array $deliveries;

    /**
     * `new IntegrationListDeliveriesResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * IntegrationListDeliveriesResponse::with(deliveries: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new IntegrationListDeliveriesResponse)->withDeliveries(...)
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
     * @param list<IntegrationDelivery|IntegrationDeliveryShape> $deliveries
     */
    public static function with(array $deliveries): self
    {
        $self = new self;

        $self['deliveries'] = $deliveries;

        return $self;
    }

    /**
     * @param list<IntegrationDelivery|IntegrationDeliveryShape> $deliveries
     */
    public function withDeliveries(array $deliveries): self
    {
        $self = clone $this;
        $self['deliveries'] = $deliveries;

        return $self;
    }
}
