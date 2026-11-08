<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Users;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Returns engagement insights for 1 profile. They are engagement rate, averages per post and posting rate, from its counts and its most recent posts. It reads 20 posts unless limit names another number. Reposts and the pinned post stay out of the averages. Each report costs 1 credit, whatever it reads.
 *
 * @see XTwitterScraper\Services\X\UsersService::retrieveInsights()
 *
 * @phpstan-type UserRetrieveInsightsParamsShape = array{
 *   limit?: int|null,
 *   fields?: string|null,
 *   omit?: string|null,
 * }
 */
final class UserRetrieveInsightsParams implements BaseModel
{
    /** @use SdkModel<UserRetrieveInsightsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Recent posts to read for the averages and rates. The read stops at this count, at the account's oldest post or after about 40 seconds. `sample.read` says how many it read, and `sample.posts` how many of those the averages used. `pageSize`, `count`, `max_results`, `maxItems`, `max_items` & `per_page` are accepted aliases.
     */
    #[Optional]
    public ?int $limit;

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
    public static function with(?int $limit = null, ?string $fields = null, ?string $omit = null): self
    {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $fields && $self['fields'] = $fields;
        null !== $omit && $self['omit'] = $omit;

        return $self;
    }

    /**
     * Recent posts to read for the averages and rates. The read stops at this count, at the account's oldest post or after about 40 seconds. `sample.read` says how many it read, and `sample.posts` how many of those the averages used. `pageSize`, `count`, `max_results`, `maxItems`, `max_items` & `per_page` are accepted aliases.
     */
    public function withLimit(?int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

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
