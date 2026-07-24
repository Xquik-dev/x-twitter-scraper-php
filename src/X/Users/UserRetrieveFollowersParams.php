<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Users;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * List followers of a user.
 *
 * @see XTwitterScraper\Services\X\UsersService::retrieveFollowers()
 *
 * @phpstan-type UserRetrieveFollowersParamsShape = array{
 *   after?: string|null,
 *   cursor?: string|null,
 *   limit?: int|null,
 *   pageSize?: int|null,
 * }
 */
final class UserRetrieveFollowersParams implements BaseModel
{
    /** @use SdkModel<UserRetrieveFollowersParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Legacy cursor alias. Prefer cursor.
     */
    #[Optional]
    public ?string $after;

    /**
     * Pagination cursor for followers list.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Legacy integer page size alias for following lists. Prefer pageSize.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Maximum user profiles requested from this page (20-200, default 200). The response can contain fewer profiles because the source returned fewer or remaining credits cover fewer results. Keep requesting next_cursor while has_next_page is true. The deprecated limit and count aliases remain accepted.
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
    public static function with(
        ?string $after = null,
        ?string $cursor = null,
        ?int $limit = null,
        ?int $pageSize = null,
    ): self {
        $self = new self;

        null !== $after && $self['after'] = $after;
        null !== $cursor && $self['cursor'] = $cursor;
        null !== $limit && $self['limit'] = $limit;
        null !== $pageSize && $self['pageSize'] = $pageSize;

        return $self;
    }

    /**
     * Legacy cursor alias. Prefer cursor.
     */
    public function withAfter(string $after): self
    {
        $self = clone $this;
        $self['after'] = $after;

        return $self;
    }

    /**
     * Pagination cursor for followers list.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Legacy integer page size alias for following lists. Prefer pageSize.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Maximum user profiles requested from this page (20-200, default 200). The response can contain fewer profiles because the source returned fewer or remaining credits cover fewer results. Keep requesting next_cursor while has_next_page is true. The deprecated limit and count aliases remain accepted.
     */
    public function withPageSize(int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

        return $self;
    }
}
