<?php

declare(strict_types=1);

namespace XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ScorerWeightShape = array{
 *   context: string, signal: string, weight: null|null
 * }
 */
final class ScorerWeight implements BaseModel
{
    /** @use SdkModel<ScorerWeightShape> */
    use SdkModel;

    /**
     * Signal direction and publication limit.
     */
    #[Required]
    public string $context;

    /**
     * Signal name from X's public ranking repository.
     */
    #[Required]
    public string $signal;

    /**
     * X does not publish the production weight.
     *
     * @var null|null $weight
     */
    #[Required]
    public null $weight;

    /**
     * `new ScorerWeight()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ScorerWeight::with(context: ..., signal: ..., weight: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ScorerWeight)->withContext(...)->withSignal(...)->withWeight(...)
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
     * @param null|null $weight
     */
    public static function with(
        string $context,
        string $signal,
        null $weight
    ): self {
        $self = new self;

        $self['context'] = $context;
        $self['signal'] = $signal;
        $self['weight'] = $weight;

        return $self;
    }

    /**
     * Signal direction and publication limit.
     */
    public function withContext(string $context): self
    {
        $self = clone $this;
        $self['context'] = $context;

        return $self;
    }

    /**
     * Signal name from X's public ranking repository.
     */
    public function withSignal(string $signal): self
    {
        $self = clone $this;
        $self['signal'] = $signal;

        return $self;
    }

    /**
     * X does not publish the production weight.
     *
     * @param null|null $weight
     */
    public function withWeight(null $weight): self
    {
        $self = clone $this;
        $self['weight'] = $weight;

        return $self;
    }
}
