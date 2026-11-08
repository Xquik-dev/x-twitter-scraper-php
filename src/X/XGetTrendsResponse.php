<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\TrendLocation;
use XTwitterScraper\X\XGetTrendsResponse\Trend;

/**
 * @phpstan-import-type TrendShape from Trend
 *
 * @phpstan-type XGetTrendsResponseShape = array{
 *   count: int, trends: list<Trend|TrendShape>, woeid: int,
 *   location?: TrendLocation|array<string,mixed>|null,
 *   capturedAt?: \DateTimeInterface|null,
 *   requestedAt?: \DateTimeInterface|null,
 * }
 */
final class XGetTrendsResponse implements BaseModel
{
    /** @use SdkModel<XGetTrendsResponseShape> */
    use SdkModel;

    #[Required]
    public int $count;

    /** @var list<Trend> $trends */
    #[Required(list: Trend::class)]
    public array $trends;

    #[Required]
    public int $woeid;

    /**
     * The place country or location named. Absent when woeid picked the place or the request named none.
     */
    #[Optional]
    public ?TrendLocation $location;

    /**
     * When Xquik read this list from X. It comes from the stored list and is never estimated.
     */
    #[Optional]
    public ?\DateTimeInterface $capturedAt;

    /**
     * The time the at parameter asked for, as Xquik read it. A span such as 24h shows here as the time it counted back to. Present only with at.
     */
    #[Optional]
    public ?\DateTimeInterface $requestedAt;

    /**
     * `new XGetTrendsResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XGetTrendsResponse::with(count: ..., trends: ..., woeid: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XGetTrendsResponse)->withCount(...)->withTrends(...)->withWoeid(...)
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
     * @param list<Trend|TrendShape> $trends
     * @param TrendLocation|array<string,mixed>|null $location
     */
    public static function with(int $count, array $trends, int $woeid, TrendLocation|array|null $location = null, ?\DateTimeInterface $capturedAt = null, ?\DateTimeInterface $requestedAt = null): self
    {
        $self = new self;

        $self['count'] = $count;
        $self['trends'] = $trends;
        $self['woeid'] = $woeid;

        null !== $location && $self['location'] = $location;

        null !== $capturedAt && $self['capturedAt'] = $capturedAt;

        null !== $requestedAt && $self['requestedAt'] = $requestedAt;

        return $self;
    }

    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    /**
     * @param list<Trend|TrendShape> $trends
     */
    public function withTrends(array $trends): self
    {
        $self = clone $this;
        $self['trends'] = $trends;

        return $self;
    }

    public function withWoeid(int $woeid): self
    {
        $self = clone $this;
        $self['woeid'] = $woeid;

        return $self;
    }

    /**
     * The place country or location named. Absent when woeid picked the place or the request named none.
     *
     * @param TrendLocation|array<string,mixed>|null $location
     */
    public function withLocation(TrendLocation|array|null $location): self
    {
        $self = clone $this;
        $self['location'] = $location;

        return $self;
    }

    /**
     * When Xquik read this list from X. It comes from the stored list and is never estimated.
     */
    public function withCapturedAt(?\DateTimeInterface $capturedAt): self
    {
        $self = clone $this;
        $self['capturedAt'] = $capturedAt;

        return $self;
    }

    /**
     * The time the at parameter asked for, as Xquik read it. A span such as 24h shows here as the time it counted back to. Present only with at.
     */
    public function withRequestedAt(?\DateTimeInterface $requestedAt): self
    {
        $self = clone $this;
        $self['requestedAt'] = $requestedAt;

        return $self;
    }
}
