<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetDetail;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CashtagAttachmentsShape = array{
 *   cashtag: string,
 *   candleSize?: string|null,
 *   timeframe?: string|null,
 *   startTime?: \DateTimeInterface|null,
 *   endTime?: \DateTimeInterface|null,
 *   sizeVariant?: int|null,
 * }
 */
final class CashtagAttachments implements BaseModel
{
    /** @use SdkModel<CashtagAttachmentsShape> */
    use SdkModel;

    /**
     * The cashtag with its `$`.
     */
    #[Required]
    public string $cashtag;

    /**
     * Span of each candle.
     */
    #[Optional]
    public ?string $candleSize;

    /**
     * Span the chart covers.
     */
    #[Optional]
    public ?string $timeframe;

    /**
     * Time of the chart's first candle.
     */
    #[Optional]
    public ?\DateTimeInterface $startTime;

    /**
     * Time of the chart's last price.
     */
    #[Optional]
    public ?\DateTimeInterface $endTime;

    /**
     * X's size for the chart.
     */
    #[Optional]
    public ?int $sizeVariant;

    /**
     * `new CashtagAttachments()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CashtagAttachments::with(cashtag: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CashtagAttachments)->withCashtag(...)
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
    public static function with(string $cashtag, ?string $candleSize = null, ?string $timeframe = null, ?\DateTimeInterface $startTime = null, ?\DateTimeInterface $endTime = null, ?int $sizeVariant = null): self
    {
        $self = new self;

        $self['cashtag'] = $cashtag;

        null !== $candleSize && $self['candleSize'] = $candleSize;
        null !== $timeframe && $self['timeframe'] = $timeframe;
        null !== $startTime && $self['startTime'] = $startTime;
        null !== $endTime && $self['endTime'] = $endTime;
        null !== $sizeVariant && $self['sizeVariant'] = $sizeVariant;

        return $self;
    }

    /**
     * The cashtag with its `$`.
     */
    public function withCashtag(string $cashtag): self
    {
        $self = clone $this;
        $self['cashtag'] = $cashtag;

        return $self;
    }

    /**
     * Span of each candle.
     */
    public function withCandleSize(?string $candleSize): self
    {
        $self = clone $this;
        $self['candleSize'] = $candleSize;

        return $self;
    }

    /**
     * Span the chart covers.
     */
    public function withTimeframe(?string $timeframe): self
    {
        $self = clone $this;
        $self['timeframe'] = $timeframe;

        return $self;
    }

    /**
     * Time of the chart's first candle.
     */
    public function withStartTime(?\DateTimeInterface $startTime): self
    {
        $self = clone $this;
        $self['startTime'] = $startTime;

        return $self;
    }

    /**
     * Time of the chart's last price.
     */
    public function withEndTime(?\DateTimeInterface $endTime): self
    {
        $self = clone $this;
        $self['endTime'] = $endTime;

        return $self;
    }

    /**
     * X's size for the chart.
     */
    public function withSizeVariant(?int $sizeVariant): self
    {
        $self = clone $this;
        $self['sizeVariant'] = $sizeVariant;

        return $self;
    }
}
