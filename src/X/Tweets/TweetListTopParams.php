<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Tweets\TweetListTopParams\Metric;
use XTwitterScraper\X\Tweets\TweetListTopParams\Window;

/**
 * Returns the tweets X ranks highest by 1 metric over the last day, week or month. Covers all of X unless you pick a country or a language. Pages hold up to 20 tweets, and the list ends at 100. Each tweet costs 1 credit.
 *
 * @see XTwitterScraper\Services\X\TweetsService::listTop()
 *
 * @phpstan-type TweetListTopParamsShape = array{
 *   metric?: Metric|value-of<Metric>|null,
 *   window?: Window|value-of<Window>|null,
 *   country?: string|null,
 *   language?: string|null,
 *   cursor?: string|null,
 *   pageSize?: int|null,
 *   fields?: string|null,
 *   omit?: string|null,
 * }
 */
final class TweetListTopParams implements BaseModel
{
    /** @use SdkModel<TweetListTopParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * What to rank tweets by. Defaults to likes. Singular names work too, such as like.
     *
     * @var value-of<Metric>|null $metric
     */
    #[Optional(enum: Metric::class)]
    public ?string $metric;

    /**
     * How far back to look. Defaults to day. Also takes 24h, 7d, 30d, daily, weekly and monthly.
     *
     * @var value-of<Window>|null $window
     */
    #[Optional(enum: Window::class)]
    public ?string $window;

    /**
     * Only tweets from 1 country, as a 2- or 3-letter ISO 3166 code, such as US or USA. Send country or language, not both.
     */
    #[Optional]
    public ?string $country;

    /**
     * Only tweets in 1 language, as a 2-letter code, such as en. Send country or language, not both.
     */
    #[Optional]
    public ?string $language;

    /**
     * Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Items per page (1-100, default 20). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     */
    #[Optional]
    public ?int $pageSize;

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
     *
     * @param Metric|value-of<Metric>|null $metric
     * @param Window|value-of<Window>|null $window
     */
    public static function with(Metric|string|null $metric = null, Window|string|null $window = null, ?string $country = null, ?string $language = null, ?string $cursor = null, ?int $pageSize = null, ?string $fields = null, ?string $omit = null): self
    {
        $self = new self;

        null !== $metric && $self['metric'] = $metric;
        null !== $window && $self['window'] = $window;
        null !== $country && $self['country'] = $country;
        null !== $language && $self['language'] = $language;
        null !== $cursor && $self['cursor'] = $cursor;
        null !== $pageSize && $self['pageSize'] = $pageSize;
        null !== $fields && $self['fields'] = $fields;
        null !== $omit && $self['omit'] = $omit;

        return $self;
    }

    /**
     * What to rank tweets by. Defaults to likes. Singular names work too, such as like.
     *
     * @param Metric|value-of<Metric>|null $metric
     */
    public function withMetric(Metric|string|null $metric): self
    {
        $self = clone $this;
        $self['metric'] = $metric;

        return $self;
    }

    /**
     * How far back to look. Defaults to day. Also takes 24h, 7d, 30d, daily, weekly and monthly.
     *
     * @param Window|value-of<Window>|null $window
     */
    public function withWindow(Window|string|null $window): self
    {
        $self = clone $this;
        $self['window'] = $window;

        return $self;
    }

    /**
     * Only tweets from 1 country, as a 2- or 3-letter ISO 3166 code, such as US or USA. Send country or language, not both.
     */
    public function withCountry(?string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * Only tweets in 1 language, as a 2-letter code, such as en. Send country or language, not both.
     */
    public function withLanguage(?string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     */
    public function withCursor(?string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Items per page (1-100, default 20). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     */
    public function withPageSize(?int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

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
