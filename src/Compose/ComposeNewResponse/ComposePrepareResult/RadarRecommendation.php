<?php

declare(strict_types=1);

namespace XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult;

use XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult\RadarRecommendation\Source;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type RadarRecommendationShape = array{
 *   endpoint: string,
 *   guidance: string,
 *   source: Source|value-of<Source>,
 *   useFor: string,
 * }
 */
final class RadarRecommendation implements BaseModel
{
    /** @use SdkModel<RadarRecommendationShape> */
    use SdkModel;

    /**
     * Radar endpoint for this source.
     */
    #[Required]
    public string $endpoint;

    /**
     * Source-specific drafting guidance.
     */
    #[Required]
    public string $guidance;

    /** @var value-of<Source> $source */
    #[Required(enum: Source::class)]
    public string $source;

    /**
     * Current-topic research this source supports.
     */
    #[Required]
    public string $useFor;

    /**
     * `new RadarRecommendation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RadarRecommendation::with(
     *   endpoint: ..., guidance: ..., source: ..., useFor: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RadarRecommendation)
     *   ->withEndpoint(...)
     *   ->withGuidance(...)
     *   ->withSource(...)
     *   ->withUseFor(...)
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
     * @param Source|value-of<Source> $source
     */
    public static function with(
        string $endpoint,
        string $guidance,
        Source|string $source,
        string $useFor
    ): self {
        $self = new self;

        $self['endpoint'] = $endpoint;
        $self['guidance'] = $guidance;
        $self['source'] = $source;
        $self['useFor'] = $useFor;

        return $self;
    }

    /**
     * Radar endpoint for this source.
     */
    public function withEndpoint(string $endpoint): self
    {
        $self = clone $this;
        $self['endpoint'] = $endpoint;

        return $self;
    }

    /**
     * Source-specific drafting guidance.
     */
    public function withGuidance(string $guidance): self
    {
        $self = clone $this;
        $self['guidance'] = $guidance;

        return $self;
    }

    /**
     * @param Source|value-of<Source> $source
     */
    public function withSource(Source|string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    /**
     * Current-topic research this source supports.
     */
    public function withUseFor(string $useFor): self
    {
        $self = clone $this;
        $self['useFor'] = $useFor;

        return $self;
    }
}
