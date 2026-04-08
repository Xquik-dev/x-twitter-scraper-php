<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Communities;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Communities\CommunityGetMembersResponse\User;

/**
 * Paginated list of user profiles with cursor-based navigation.
 *
 * @phpstan-import-type UserShape from \XTwitterScraper\X\Communities\CommunityGetMembersResponse\User
 *
 * @phpstan-type CommunityGetMembersResponseShape = array{
 *   hasNextPage: bool, nextCursor: string, users: list<User|UserShape>
 * }
 */
final class CommunityGetMembersResponse implements BaseModel
{
    /** @use SdkModel<CommunityGetMembersResponseShape> */
    use SdkModel;

    #[Required('has_next_page')]
    public bool $hasNextPage;

    #[Required('next_cursor')]
    public string $nextCursor;

    /** @var list<User> $users */
    #[Required(list: User::class)]
    public array $users;

    /**
     * `new CommunityGetMembersResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CommunityGetMembersResponse::with(hasNextPage: ..., nextCursor: ..., users: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CommunityGetMembersResponse)
     *   ->withHasNextPage(...)
     *   ->withNextCursor(...)
     *   ->withUsers(...)
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
     * @param list<User|UserShape> $users
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
     * @param list<User|UserShape> $users
     */
    public function withUsers(array $users): self
    {
        $self = clone $this;
        $self['users'] = $users;

        return $self;
    }
}
