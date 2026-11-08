<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ProfileContactInfo;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\ProfileContactInfo\Phones\Source;

/**
 * @phpstan-type PhonesShape = array{
 *   value: string,
 *   source: Source|value-of<Source>,
 *   writtenAs?: string|null,
 * }
 */
final class Phones implements BaseModel
{
    /** @use SdkModel<PhonesShape> */
    use SdkModel;

    /**
     * The digits, with a leading + when the account wrote a country code.
     */
    #[Required]
    public string $value;

    /**
     * Profile field that holds the number.
     *
     * @var value-of<Source> $source
     */
    #[Required(enum: Source::class)]
    public string $source;

    /**
     * The account's own spelling of the number.
     */
    #[Optional]
    public ?string $writtenAs;

    /**
     * `new Phones()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Phones::with(value: ..., source: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Phones)->withValue(...)->withSource(...)
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
    public static function with(string $value, Source|string $source, ?string $writtenAs = null): self
    {
        $self = new self;

        $self['value'] = $value;
        $self['source'] = $source;

        null !== $writtenAs && $self['writtenAs'] = $writtenAs;

        return $self;
    }

    /**
     * The digits, with a leading + when the account wrote a country code.
     */
    public function withValue(string $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }

    /**
     * Profile field that holds the number.
     *
     * @param Source|value-of<Source> $source
     */
    public function withSource(Source|string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    /**
     * The account's own spelling of the number.
     */
    public function withWrittenAs(?string $writtenAs): self
    {
        $self = clone $this;
        $self['writtenAs'] = $writtenAs;

        return $self;
    }
}
