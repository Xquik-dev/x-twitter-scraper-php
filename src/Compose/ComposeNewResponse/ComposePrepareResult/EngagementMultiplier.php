<?php

declare(strict_types=1);

namespace XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type EngagementMultiplierShape = array{
 *   action: string, multiplier: 'Production weight not published by X'
 * }
 */
final class EngagementMultiplier implements BaseModel
{
    /** @use SdkModel<EngagementMultiplierShape> */
    use SdkModel;

    /** @var 'Production weight not published by X' $multiplier */
    #[Required]
    public string $multiplier = 'Production weight not published by X';

    /**
     * Human-readable published signal name.
     */
    #[Required]
    public string $action;

    /**
     * `new EngagementMultiplier()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * EngagementMultiplier::with(action: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new EngagementMultiplier)->withAction(...)
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
     */
    public static function with(string $action): self
    {
        $self = new self;

        $self['action'] = $action;

        return $self;
    }

    /**
     * Human-readable published signal name.
     */
    public function withAction(string $action): self
    {
        $self = clone $this;
        $self['action'] = $action;

        return $self;
    }

    /**
     * @param 'Production weight not published by X' $multiplier
     */
    public function withMultiplier(string $multiplier): self
    {
        $self = clone $this;
        $self['multiplier'] = $multiplier;

        return $self;
    }
}
