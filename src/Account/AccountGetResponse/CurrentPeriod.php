<?php

declare(strict_types=1);

namespace XTwitterScraper\Account\AccountGetResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CurrentPeriodShape = array{
 *   end: \DateTimeInterface, start: \DateTimeInterface, usagePercent: float
 * }
 */
final class CurrentPeriod implements BaseModel
{
    /** @use SdkModel<CurrentPeriodShape> */
    use SdkModel;

    #[Required]
    public \DateTimeInterface $end;

    #[Required]
    public \DateTimeInterface $start;

    #[Required]
    public float $usagePercent;

    /**
     * `new CurrentPeriod()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CurrentPeriod::with(end: ..., start: ..., usagePercent: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CurrentPeriod)->withEnd(...)->withStart(...)->withUsagePercent(...)
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
    public static function with(
        \DateTimeInterface $end,
        \DateTimeInterface $start,
        float $usagePercent
    ): self {
        $self = new self;

        $self['end'] = $end;
        $self['start'] = $start;
        $self['usagePercent'] = $usagePercent;

        return $self;
    }

    public function withEnd(\DateTimeInterface $end): self
    {
        $self = clone $this;
        $self['end'] = $end;

        return $self;
    }

    public function withStart(\DateTimeInterface $start): self
    {
        $self = clone $this;
        $self['start'] = $start;

        return $self;
    }

    public function withUsagePercent(float $usagePercent): self
    {
        $self = clone $this;
        $self['usagePercent'] = $usagePercent;

        return $self;
    }
}
