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
 * Returns the newest posts of up to 20 users, named by user ID, username or profile link, in the order named. Send ids or usernames, not both. Each post costs 1 credit. A user in unavailable_ids or unprocessed_ids costs nothing.
 *
 * @see XTwitterScraper\Services\X\UsersService::retrieveBatchTweets()
 *
 * @phpstan-type UserRetrieveBatchTweetsParamsShape = array{
 *   ids?: string|null,
 *   usernames?: string|null,
 *   pageSize?: int|null,
 *   fields?: string|null,
 *   omit?: string|null,
 * }
 */
final class UserRetrieveBatchTweetsParams implements BaseModel
{
    /** @use SdkModel<UserRetrieveBatchTweetsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Comma-separated numeric user IDs (1-20 values). Xquik reads any other entry as a username, with or without @, so IDs and usernames can mix. Xquik ignores duplicates and keeps the first-seen order, IDs before usernames. A longer URL fails at the edge before Xquik reads it.
     */
    #[Optional]
    public ?string $ids;

    /**
     * Comma-separated X usernames, with or without @, or profile links such as x.com/nasa (1-20 values), in place of ids. A name in another case is the same account. A number is a user ID. A longer URL fails at the edge before Xquik reads it.
     */
    #[Optional]
    public ?string $usernames;

    /**
     * Posts per user (1-20, default 20). A low credit balance can return fewer. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
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
     */
    public static function with(?string $ids = null, ?string $usernames = null, ?int $pageSize = null, ?string $fields = null, ?string $omit = null): self
    {
        $self = new self;

        null !== $ids && $self['ids'] = $ids;
        null !== $usernames && $self['usernames'] = $usernames;
        null !== $pageSize && $self['pageSize'] = $pageSize;
        null !== $fields && $self['fields'] = $fields;
        null !== $omit && $self['omit'] = $omit;

        return $self;
    }

    /**
     * Comma-separated numeric user IDs (1-20 values). Xquik reads any other entry as a username, with or without @, so IDs and usernames can mix. Xquik ignores duplicates and keeps the first-seen order, IDs before usernames. A longer URL fails at the edge before Xquik reads it.
     */
    public function withIds(?string $ids): self
    {
        $self = clone $this;
        $self['ids'] = $ids;

        return $self;
    }

    /**
     * Comma-separated X usernames, with or without @, or profile links such as x.com/nasa (1-20 values), in place of ids. A name in another case is the same account. A number is a user ID. A longer URL fails at the edge before Xquik reads it.
     */
    public function withUsernames(?string $usernames): self
    {
        $self = clone $this;
        $self['usernames'] = $usernames;

        return $self;
    }

    /**
     * Posts per user (1-20, default 20). A low credit balance can return fewer. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
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
