<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Extractions\ExtractionEstimateCostResponse\Source;

/**
 * @phpstan-type ExtractionEstimateCostResponseShape = array{
 *   allowed: bool,
 *   creditsAvailable: string,
 *   creditsRequired: string,
 *   estimatedResults: int,
 *   source: Source|value-of<Source>,
 *   resolvedXUserID?: string|null,
 * }
 */
final class ExtractionEstimateCostResponse implements BaseModel
{
    /** @use SdkModel<ExtractionEstimateCostResponseShape> */
    use SdkModel;

    #[Required]
    public bool $allowed;

    #[Required]
    public string $creditsAvailable;

    #[Required]
    public string $creditsRequired;

    #[Required]
    public int $estimatedResults;

    /** @var value-of<Source> $source */
    #[Required(enum: Source::class)]
    public string $source;

    #[Optional('resolvedXUserId')]
    public ?string $resolvedXUserID;

    /**
     * `new ExtractionEstimateCostResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExtractionEstimateCostResponse::with(
     *   allowed: ...,
     *   creditsAvailable: ...,
     *   creditsRequired: ...,
     *   estimatedResults: ...,
     *   source: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExtractionEstimateCostResponse)
     *   ->withAllowed(...)
     *   ->withCreditsAvailable(...)
     *   ->withCreditsRequired(...)
     *   ->withEstimatedResults(...)
     *   ->withSource(...)
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
        bool $allowed,
        string $creditsAvailable,
        string $creditsRequired,
        int $estimatedResults,
        Source|string $source,
        ?string $resolvedXUserID = null,
    ): self {
        $self = new self;

        $self['allowed'] = $allowed;
        $self['creditsAvailable'] = $creditsAvailable;
        $self['creditsRequired'] = $creditsRequired;
        $self['estimatedResults'] = $estimatedResults;
        $self['source'] = $source;

        null !== $resolvedXUserID && $self['resolvedXUserID'] = $resolvedXUserID;

        return $self;
    }

    public function withAllowed(bool $allowed): self
    {
        $self = clone $this;
        $self['allowed'] = $allowed;

        return $self;
    }

    public function withCreditsAvailable(string $creditsAvailable): self
    {
        $self = clone $this;
        $self['creditsAvailable'] = $creditsAvailable;

        return $self;
    }

    public function withCreditsRequired(string $creditsRequired): self
    {
        $self = clone $this;
        $self['creditsRequired'] = $creditsRequired;

        return $self;
    }

    public function withEstimatedResults(int $estimatedResults): self
    {
        $self = clone $this;
        $self['estimatedResults'] = $estimatedResults;

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

    public function withResolvedXUserID(string $resolvedXUserID): self
    {
        $self = clone $this;
        $self['resolvedXUserID'] = $resolvedXUserID;

        return $self;
    }
}
