<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Returns the Twitter trends archive of a place, as the lists X showed there over a range of time. Use it for trending on Twitter yesterday, last week or any day since 2026-10-13 02:20 UTC. Xquik stores 1 list per place every 5 minutes and keeps it for 25 months. Pick the place by woeid, country or location name, the range with from & to, and the step with every. from & to take a time or a span back from now, such as 7d, so a schedule can read the last day on every run. Each step returns the first list stored in it, with its own time. Each returned list costs 1 credit, so 24 lists cost 24 credits. A step with no stored list returns none. Empty trend history steps are free. 1 request returns 24 lists, or up to 100 with limit.
 *
 * @see XTwitterScraper\Services\XService::getTrendsHistory()
 *
 * @phpstan-type XGetTrendsHistoryParamsShape = array{
 *   woeid?: int|null,
 *   country?: string|null,
 *   location?: string|null,
 *   from?: string|null,
 *   to?: string|null,
 *   every?: string|null,
 *   count?: int|null,
 *   limit?: int|null,
 *   cursor?: string|null,
 *   fields?: string|null,
 *   omit?: string|null,
 * }
 */
final class XGetTrendsHistoryParams implements BaseModel
{
    /** @use SdkModel<XGetTrendsHistoryParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * WOEID of the place, such as 1 for Worldwide or 23424969 for Turkey. It wins over country & location. /x/trends/locations lists every WOEID.
     */
    #[Optional]
    public ?int $woeid;

    /**
     * Country to read trends history for, by name or 2-letter code, such as Turkey or TR. Case insensitive. X can add places, so Xquik takes up to 280 characters, the most a post holds.
     */
    #[Optional]
    public ?string $country;

    /**
     * Town or country to read trends history for, by name, such as Istanbul. Case insensitive. Add country when 2 towns share a name. /x/trends/locations lists every name. X can add places, so Xquik takes up to 280 characters, the most a post holds.
     */
    #[Optional]
    public ?string $location;

    /**
     * Start of the range. Takes an ISO 8601 time, a date such as 2026-10-13, or Unix seconds. A time without a zone reads as UTC. It also takes a span back from now, as a number & s, m, h or d, so from=7d reads the last 7 days. Defaults to 24 hours before to. History starts 2026-10-13 02:20 UTC, and a range that begins earlier returns the stored part. Alias sinceTime.
     */
    #[Optional]
    public ?string $from;

    /**
     * End of the range, which it leaves out. Takes the forms of from, so from=2d with to=1d reads the day before the last 24 hours. Defaults to now. Alias untilTime.
     */
    #[Optional]
    public ?string $to;

    /**
     * Step between 2 returned lists, as a number & m, h or d, such as 15m, 1h or 1d. A step under 5m returns every stored list.
     */
    #[Optional]
    public ?string $every;

    /**
     * Trends to return in each list.
     */
    #[Optional]
    public ?int $count;

    /**
     * Maximum lists 1 request returns & charges. A wider range gives a next_cursor for the next lists. A low credit balance can return fewer.
     */
    #[Optional]
    public ?int $limit;

    /**
     * The next_cursor of the page before, for the next lists. It keeps the time of the first request, so a range of spans stays the same on every page.
     */
    #[Optional]
    public ?string $cursor;

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
    public static function with(?int $woeid = null, ?string $country = null, ?string $location = null, ?string $from = null, ?string $to = null, ?string $every = null, ?int $count = null, ?int $limit = null, ?string $cursor = null, ?string $fields = null, ?string $omit = null): self
    {
        $self = new self;

        null !== $woeid && $self['woeid'] = $woeid;
        null !== $country && $self['country'] = $country;
        null !== $location && $self['location'] = $location;
        null !== $from && $self['from'] = $from;
        null !== $to && $self['to'] = $to;
        null !== $every && $self['every'] = $every;
        null !== $count && $self['count'] = $count;
        null !== $limit && $self['limit'] = $limit;
        null !== $cursor && $self['cursor'] = $cursor;
        null !== $fields && $self['fields'] = $fields;
        null !== $omit && $self['omit'] = $omit;

        return $self;
    }

    /**
     * WOEID of the place, such as 1 for Worldwide or 23424969 for Turkey. It wins over country & location. /x/trends/locations lists every WOEID.
     */
    public function withWoeid(?int $woeid): self
    {
        $self = clone $this;
        $self['woeid'] = $woeid;

        return $self;
    }

    /**
     * Country to read trends history for, by name or 2-letter code, such as Turkey or TR. Case insensitive. X can add places, so Xquik takes up to 280 characters, the most a post holds.
     */
    public function withCountry(?string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * Town or country to read trends history for, by name, such as Istanbul. Case insensitive. Add country when 2 towns share a name. /x/trends/locations lists every name. X can add places, so Xquik takes up to 280 characters, the most a post holds.
     */
    public function withLocation(?string $location): self
    {
        $self = clone $this;
        $self['location'] = $location;

        return $self;
    }

    /**
     * Start of the range. Takes an ISO 8601 time, a date such as 2026-10-13, or Unix seconds. A time without a zone reads as UTC. It also takes a span back from now, as a number & s, m, h or d, so from=7d reads the last 7 days. Defaults to 24 hours before to. History starts 2026-10-13 02:20 UTC, and a range that begins earlier returns the stored part. Alias sinceTime.
     */
    public function withFrom(?string $from): self
    {
        $self = clone $this;
        $self['from'] = $from;

        return $self;
    }

    /**
     * End of the range, which it leaves out. Takes the forms of from, so from=2d with to=1d reads the day before the last 24 hours. Defaults to now. Alias untilTime.
     */
    public function withTo(?string $to): self
    {
        $self = clone $this;
        $self['to'] = $to;

        return $self;
    }

    /**
     * Step between 2 returned lists, as a number & m, h or d, such as 15m, 1h or 1d. A step under 5m returns every stored list.
     */
    public function withEvery(?string $every): self
    {
        $self = clone $this;
        $self['every'] = $every;

        return $self;
    }

    /**
     * Trends to return in each list.
     */
    public function withCount(?int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    /**
     * Maximum lists 1 request returns & charges. A wider range gives a next_cursor for the next lists. A low credit balance can return fewer.
     */
    public function withLimit(?int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * The next_cursor of the page before, for the next lists. It keeps the time of the first request, so a range of spans stays the same on every page.
     */
    public function withCursor(?string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

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
