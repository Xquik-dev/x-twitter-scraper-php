<?php

declare(strict_types=1);

namespace XTwitterScraper\Integrations;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * List integration delivery history.
 *
 * @see XTwitterScraper\Services\IntegrationsService::listDeliveries()
 *
 * @phpstan-type IntegrationListDeliveriesParamsShape = array{limit?: int|null}
 */
final class IntegrationListDeliveriesParams implements BaseModel
{
    /** @use SdkModel<IntegrationListDeliveriesParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Maximum number of items to return (1-100, default 50).
     */
    #[Optional]
    public ?int $limit;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $limit = null): self
    {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;

        return $self;
    }

    /**
     * Maximum number of items to return (1-100, default 50).
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }
}
