<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ExtractionEstimateCostResponseShape = array{
 *   allowed: bool,
 *   estimatedResults: int,
 *   projectedPercent: float,
 *   source: string,
 *   usagePercent: float,
 * }
 */
final class ExtractionEstimateCostResponse implements BaseModel
{
    /** @use SdkModel<ExtractionEstimateCostResponseShape> */
    use SdkModel;

    #[Required]
    public bool $allowed;

    #[Required]
    public int $estimatedResults;

    #[Required]
    public float $projectedPercent;

    #[Required]
    public string $source;

    #[Required]
    public float $usagePercent;

    /**
     * `new ExtractionEstimateCostResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExtractionEstimateCostResponse::with(
     *   allowed: ...,
     *   estimatedResults: ...,
     *   projectedPercent: ...,
     *   source: ...,
     *   usagePercent: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExtractionEstimateCostResponse)
     *   ->withAllowed(...)
     *   ->withEstimatedResults(...)
     *   ->withProjectedPercent(...)
     *   ->withSource(...)
     *   ->withUsagePercent(...)
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
        bool $allowed,
        int $estimatedResults,
        float $projectedPercent,
        string $source,
        float $usagePercent,
    ): self {
        $self = new self;

        $self['allowed'] = $allowed;
        $self['estimatedResults'] = $estimatedResults;
        $self['projectedPercent'] = $projectedPercent;
        $self['source'] = $source;
        $self['usagePercent'] = $usagePercent;

        return $self;
    }

    public function withAllowed(bool $allowed): self
    {
        $self = clone $this;
        $self['allowed'] = $allowed;

        return $self;
    }

    public function withEstimatedResults(int $estimatedResults): self
    {
        $self = clone $this;
        $self['estimatedResults'] = $estimatedResults;

        return $self;
    }

    public function withProjectedPercent(float $projectedPercent): self
    {
        $self = clone $this;
        $self['projectedPercent'] = $projectedPercent;

        return $self;
    }

    public function withSource(string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    public function withUsagePercent(float $usagePercent): self
    {
        $self = clone $this;
        $self['usagePercent'] = $usagePercent;

        return $self;
    }
}
