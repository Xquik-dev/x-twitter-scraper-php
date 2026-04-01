<?php

declare(strict_types=1);

namespace XTwitterScraper\Integrations;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Integrations\IntegrationListResponse\Integration;

/**
 * @phpstan-import-type IntegrationShape from \XTwitterScraper\Integrations\IntegrationListResponse\Integration
 *
 * @phpstan-type IntegrationListResponseShape = array{
 *   integrations: list<\XTwitterScraper\Integrations\IntegrationListResponse\Integration|IntegrationShape>,
 * }
 */
final class IntegrationListResponse implements BaseModel
{
    /** @use SdkModel<IntegrationListResponseShape> */
    use SdkModel;

    /**
     * @var list<Integration> $integrations
     */
    #[Required(
        list: Integration::class,
    )]
    public array $integrations;

    /**
     * `new IntegrationListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * IntegrationListResponse::with(integrations: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new IntegrationListResponse)->withIntegrations(...)
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
     * @param list<Integration|IntegrationShape> $integrations
     */
    public static function with(array $integrations): self
    {
        $self = new self;

        $self['integrations'] = $integrations;

        return $self;
    }

    /**
     * @param list<Integration|IntegrationShape> $integrations
     */
    public function withIntegrations(array $integrations): self
    {
        $self = clone $this;
        $self['integrations'] = $integrations;

        return $self;
    }
}
