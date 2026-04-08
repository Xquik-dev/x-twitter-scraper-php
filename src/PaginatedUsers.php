<?php

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Users\UserProfile;

/**
 * Paginated list of user profiles with cursor-based navigation.
 *
 * @phpstan-import-type UserProfileShape from \XTwitterScraper\X\Users\UserProfile
 *
 * @phpstan-type PaginatedUsersShape = array{
 *   hasNextPage: bool,
 *   nextCursor: string,
 *   users: list<UserProfile|UserProfileShape>,
 * }
 */
final class PaginatedUsers implements BaseModel
{
    /** @use SdkModel<PaginatedUsersShape> */
    use SdkModel;

    #[Required('has_next_page')]
    public bool $hasNextPage;

    #[Required('next_cursor')]
    public string $nextCursor;

    /** @var list<UserProfile> $users */
    #[Required(list: UserProfile::class)]
    public array $users;

    /**
     * `new PaginatedUsers()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PaginatedUsers::with(hasNextPage: ..., nextCursor: ..., users: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PaginatedUsers)->withHasNextPage(...)->withNextCursor(...)->withUsers(...)
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
     * @param list<UserProfile|UserProfileShape> $users
     */
    public static function with(
        bool $hasNextPage,
        string $nextCursor,
        array $users
    ): self {
        $self = new self;

        $self['hasNextPage'] = $hasNextPage;
        $self['nextCursor'] = $nextCursor;
        $self['users'] = $users;

        return $self;
    }

    public function withHasNextPage(bool $hasNextPage): self
    {
        $self = clone $this;
        $self['hasNextPage'] = $hasNextPage;

        return $self;
    }

    public function withNextCursor(string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * @param list<UserProfile|UserProfileShape> $users
     */
    public function withUsers(array $users): self
    {
        $self = clone $this;
        $self['users'] = $users;

        return $self;
    }
}
