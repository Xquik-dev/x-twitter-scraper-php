<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ScorerWeightShape = array{
 *   context: string, signal: string, weight: null
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
     * @var null
     */
    #[Required(type: 'null')]
    public mixed $weight;

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
     * @param null $weight
     */
    public static function with(
        string $context,
        string $signal,
        mixed $weight
    ): self {
        self::ensureNullWeight($weight);

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
     * @param null $weight
     */
    public function withWeight(mixed $weight): self
    {
        self::ensureNullWeight($weight);

        $self = clone $this;
        $self['weight'] = $weight;

        return $self;
    }

    private static function ensureNullWeight(mixed $weight): void
    {
        if (null !== $weight) {
            throw new \TypeError('Scorer weight must be null.');
        }
    }
}
