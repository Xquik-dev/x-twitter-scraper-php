<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get trending hashtags and topics from X by region.
 *
 * @see XTwitterScraper\Services\XService::getTrends()
 *
 * @phpstan-type XGetTrendsParamsShape = array{count?: int|null, woeid?: int|null,
 *   country?: string|null,
 *   location?: string|null,
 *   at?: string|null,
 *   fields?: string|null,
 *   omit?: string|null,
 * }
 */
final class XGetTrendsParams implements BaseModel
{
    /** @use SdkModel<XGetTrendsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Number of trending topics to return (1-50, default 30).
     */
    #[Optional]
    public ?int $count;

    /**
     * Region WOEID (1=Worldwide, 23424977=US, 23424975=UK, 23424969=Turkey).
     */
    #[Optional]
    public ?int $woeid;

    /**
     * Country to read trends for, by name or 2-letter code, such as Turkey or TR. Case insensitive. X can add places, so Xquik takes up to 280 characters, the most a post holds.
     */
    #[Optional]
    public ?string $country;

    /**
     * Town or country to read trends for, by name, such as Istanbul. Case insensitive. Add country when 2 towns share a name. /x/trends/locations lists every name. X can add places, so Xquik takes up to 280 characters, the most a post holds.
     */
    #[Optional]
    public ?string $location;

    /**
     * A past time, to read what was trending on Twitter then. Takes an ISO 8601 time, a date such as 2026-10-13, or Unix seconds. A time without a zone reads as UTC. It also takes a span back from now, as a number & s, m, h or d. So at=24h reads what was trending on Twitter yesterday at this hour, on every run of a schedule. The answer is the stored list nearest that time, with its own time in capturedAt. History starts 2026-10-13 02:20 UTC. A time over 24 hours from every stored list answers 400 at no charge.
     */
    #[Optional]
    public ?string $at;

    /**
     * Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     */
    #[Optional]
    public ?string $fields;

    /**
     * Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     */
    #[Optional]
    public ?string $omit;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $count = null, ?int $woeid = null, ?string $country = null, ?string $location = null, ?string $at = null, ?string $fields = null, ?string $omit = null): self
    {
        $self = new self;

        null !== $count && $self['count'] = $count;
        null !== $woeid && $self['woeid'] = $woeid;

        null !== $country && $self['country'] = $country;

        null !== $location && $self['location'] = $location;

        null !== $at && $self['at'] = $at;

        null !== $fields && $self['fields'] = $fields;

        null !== $omit && $self['omit'] = $omit;

        return $self;
    }

    /**
     * Number of trending topics to return (1-50, default 30).
     */
    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    /**
     * Region WOEID (1=Worldwide, 23424977=US, 23424975=UK, 23424969=Turkey).
     */
    public function withWoeid(int $woeid): self
    {
        $self = clone $this;
        $self['woeid'] = $woeid;

        return $self;
    }

    /**
     * Country to read trends for, by name or 2-letter code, such as Turkey or TR. Case insensitive. X can add places, so Xquik takes up to 280 characters, the most a post holds.
     */
    public function withCountry(?string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * Town or country to read trends for, by name, such as Istanbul. Case insensitive. Add country when 2 towns share a name. /x/trends/locations lists every name. X can add places, so Xquik takes up to 280 characters, the most a post holds.
     */
    public function withLocation(?string $location): self
    {
        $self = clone $this;
        $self['location'] = $location;

        return $self;
    }

    /**
     * A past time, to read what was trending on Twitter then. Takes an ISO 8601 time, a date such as 2026-10-13, or Unix seconds. A time without a zone reads as UTC. It also takes a span back from now, as a number & s, m, h or d. So at=24h reads what was trending on Twitter yesterday at this hour, on every run of a schedule. The answer is the stored list nearest that time, with its own time in capturedAt. History starts 2026-10-13 02:20 UTC. A time over 24 hours from every stored list answers 400 at no charge.
     */
    public function withAt(?string $at): self
    {
        $self = clone $this;
        $self['at'] = $at;

        return $self;
    }

    /**
     * Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     */
    public function withFields(?string $fields): self
    {
        $self = clone $this;
        $self['fields'] = $fields;

        return $self;
    }

    /**
     * Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     */
    public function withOmit(?string $omit): self
    {
        $self = clone $this;
        $self['omit'] = $omit;

        return $self;
    }
}
