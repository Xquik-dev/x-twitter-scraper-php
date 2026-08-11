<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Users;

use XTwitterScraper\Core\Concerns\SdkUnion;
use XTwitterScraper\Core\Conversion\Contracts\Converter;
use XTwitterScraper\Core\Conversion\Contracts\ConverterSource;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\X\Users\UserGetVerifiedFollowersResponse\UserListCoverageResponse;

/**
 * Paginated user profiles. No-mode follower, following, and verified follower requests merge independent views automatically. Response fields, page size, aliases, filters, and per-returned-profile billing stay unchanged. Existing unprefixed cursors retain legacy behavior. Follow next_cursor while has_next_page is true.
 *
 * @phpstan-import-type PaginatedUsersShape from \XTwitterScraper\PaginatedUsers
 * @phpstan-import-type UserListCoverageResponseShape from \XTwitterScraper\X\Users\UserGetVerifiedFollowersResponse\UserListCoverageResponse
 *
 * @phpstan-type UserGetVerifiedFollowersResponseVariants = PaginatedUsers|UserListCoverageResponse
 * @phpstan-type UserGetVerifiedFollowersResponseShape = UserGetVerifiedFollowersResponseVariants|PaginatedUsersShape|UserListCoverageResponseShape
 */
final class UserGetVerifiedFollowersResponse implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [PaginatedUsers::class, UserListCoverageResponse::class];
    }
}
