<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetAnalysisSummary;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\TweetAnalysisSummary\Cashtags\Signal;

/**
 * @phpstan-type CashtagsShape = array{
 *   cashtag: string,
 *   rows: int,
 *   choices: array<string,mixed>,
 *   signal?: Signal|array<string,mixed>|null,
 * }
 */
final class Cashtags implements BaseModel
{
    /** @use SdkModel<CashtagsShape> */
    use SdkModel;

    #[Required]
    public string $cashtag;

    #[Required]
    public int $rows;

    /**
     * Category counts of the cashtag's posts by question ID.
     *
     * @var array<string,mixed> $choices
     */
    #[Required(map: 'mixed')]
    public array $choices;

    #[Optional]
    public ?Signal $signal;

    /**
     * `new Cashtags()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Cashtags::with(cashtag: ..., rows: ..., choices: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Cashtags)->withCashtag(...)->withRows(...)->withChoices(...)
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
     * @param array<string,mixed> $choices
     * @param Signal|array<string,mixed>|null $signal
     */
    public static function with(string $cashtag, int $rows, array $choices, Signal|array|null $signal = null): self
    {
        $self = new self;

        $self['cashtag'] = $cashtag;
        $self['rows'] = $rows;
        $self['choices'] = $choices;

        null !== $signal && $self['signal'] = $signal;

        return $self;
    }

    public function withCashtag(string $cashtag): self
    {
        $self = clone $this;
        $self['cashtag'] = $cashtag;

        return $self;
    }

    public function withRows(int $rows): self
    {
        $self = clone $this;
        $self['rows'] = $rows;

        return $self;
    }

    /**
     * Category counts of the cashtag's posts by question ID.
     *
     * @param array<string,mixed> $choices
     */
    public function withChoices(array $choices): self
    {
        $self = clone $this;
        $self['choices'] = $choices;

        return $self;
    }

    /**
     * @param Signal|array<string,mixed>|null $signal
     */
    public function withSignal(Signal|array|null $signal): self
    {
        $self = clone $this;
        $self['signal'] = $signal;

        return $self;
    }
}
