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
use XTwitterScraper\X\XGetTrendsHistoryResponse\Snapshots;

/**
 * @phpstan-type XGetTrendsHistoryResponseShape = array{
 *   fromTime: \DateTimeInterface,
 *   toTime: \DateTimeInterface,
 *   snapshots: list<Snapshots|array<string,mixed>>,
 *   count: int,
 *   woeid: int,
 *   hasNextPage: bool,
 *   nextCursor: string,
 *   location?: TrendLocation|array<string,mixed>|null,
 * }
 */
final class XGetTrendsHistoryResponse implements BaseModel
{
    /** @use SdkModel<XGetTrendsHistoryResponseShape> */
    use SdkModel;

    /**
     * Start of the range as Xquik read it. A span such as 7d shows here as the time it counted back to.
     */
    #[Required]
    public \DateTimeInterface $fromTime;

    /**
     * End of the range as Xquik read it, which the range leaves out. Without to, it is the time of the first request.
     */
    #[Required]
    public \DateTimeInterface $toTime;

    /**
     * 1 stored list per step, oldest first. A step with no stored list is left out.
     *
     * @var list<Snapshots> $snapshots
     */
    #[Required(list: Snapshots::class)]
    public array $snapshots;

    /**
     * Lists returned & charged.
     */
    #[Required]
    public int $count;

    #[Required]
    public int $woeid;

    /**
     * Whether the range holds more lists.
     */
    #[Required('has_next_page')]
    public bool $hasNextPage;

    /**
     * Send it as cursor for the next lists. Empty on the last page.
     */
    #[Required('next_cursor')]
    public string $nextCursor;

    /**
     * The place the request named by country or location. Absent when it sent a woeid or named no place.
     */
    #[Optional]
    public ?TrendLocation $location;

    /**
     * `new XGetTrendsHistoryResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XGetTrendsHistoryResponse::with(fromTime: ..., toTime: ..., snapshots: ..., count: ..., woeid: ..., hasNextPage: ..., nextCursor: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XGetTrendsHistoryResponse)->withFromTime(...)->withToTime(...)->withSnapshots(...)->withCount(...)->withWoeid(...)->withHasNextPage(...)->withNextCursor(...)
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
     * @param list<Snapshots|array<string,mixed>> $snapshots
     * @param TrendLocation|array<string,mixed>|null $location
     */
    public static function with(\DateTimeInterface $fromTime, \DateTimeInterface $toTime, array $snapshots, int $count, int $woeid, bool $hasNextPage, string $nextCursor, TrendLocation|array|null $location = null): self
    {
        $self = new self;

        $self['fromTime'] = $fromTime;
        $self['toTime'] = $toTime;
        $self['snapshots'] = $snapshots;
        $self['count'] = $count;
        $self['woeid'] = $woeid;
        $self['hasNextPage'] = $hasNextPage;
        $self['nextCursor'] = $nextCursor;

        null !== $location && $self['location'] = $location;

        return $self;
    }

    /**
     * Start of the range as Xquik read it. A span such as 7d shows here as the time it counted back to.
     */
    public function withFromTime(\DateTimeInterface $fromTime): self
    {
        $self = clone $this;
        $self['fromTime'] = $fromTime;

        return $self;
    }

    /**
     * End of the range as Xquik read it, which the range leaves out. Without to, it is the time of the first request.
     */
    public function withToTime(\DateTimeInterface $toTime): self
    {
        $self = clone $this;
        $self['toTime'] = $toTime;

        return $self;
    }

    /**
     * 1 stored list per step, oldest first. A step with no stored list is left out.
     *
     * @param list<Snapshots|array<string,mixed>> $snapshots
     */
    public function withSnapshots(array $snapshots): self
    {
        $self = clone $this;
        $self['snapshots'] = $snapshots;

        return $self;
    }

    /**
     * Lists returned & charged.
     */
    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    public function withWoeid(int $woeid): self
    {
        $self = clone $this;
        $self['woeid'] = $woeid;

        return $self;
    }

    /**
     * Whether the range holds more lists.
     */
    public function withHasNextPage(bool $hasNextPage): self
    {
        $self = clone $this;
        $self['hasNextPage'] = $hasNextPage;

        return $self;
    }

    /**
     * Send it as cursor for the next lists. Empty on the last page.
     */
    public function withNextCursor(string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * The place the request named by country or location. Absent when it sent a woeid or named no place.
     *
     * @param TrendLocation|array<string,mixed>|null $location
     */
    public function withLocation(TrendLocation|array|null $location): self
    {
        $self = clone $this;
        $self['location'] = $location;

        return $self;
    }
}
