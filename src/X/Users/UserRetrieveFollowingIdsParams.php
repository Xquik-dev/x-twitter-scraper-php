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
 * Returns the user IDs of the accounts the selected user follows, newest first, up to 5,000 a page. Use it when you need IDs only. Each ID costs 1 credit.
 *
 * @see XTwitterScraper\Services\X\UsersService::retrieveFollowingIds()
 *
 * @phpstan-type UserRetrieveFollowingIdsParamsShape = array{
 *   cursor?: string|null,
 *   pageSize?: int|null,
 * }
 */
final class UserRetrieveFollowingIdsParams implements BaseModel
{
    /** @use SdkModel<UserRetrieveFollowingIdsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * User IDs to request from this page (1-5000, default 5000). A low credit balance can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     */
    #[Optional]
    public ?int $pageSize;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $cursor = null, ?int $pageSize = null): self
    {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $pageSize && $self['pageSize'] = $pageSize;

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
     * User IDs to request from this page (1-5000, default 5000). A low credit balance can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     */
    public function withPageSize(?int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

        return $self;
    }
}
