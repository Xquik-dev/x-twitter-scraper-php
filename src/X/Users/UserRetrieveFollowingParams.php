<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Users;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get users this user follows.
 *
 * @see XTwitterScraper\Services\X\UsersService::retrieveFollowing()
 *
 * @phpstan-type UserRetrieveFollowingParamsShape = array{
 *   cursor?: string|null, pageSize?: int|null
 * }
 */
final class UserRetrieveFollowingParams implements BaseModel
{
    /** @use SdkModel<UserRetrieveFollowingParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Pagination cursor.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Items per page (20-200, default 200).
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
        ?string $cursor = null,
        ?int $pageSize = null
    ): self {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $pageSize && $self['pageSize'] = $pageSize;

        return $self;
    }

    /**
     * Pagination cursor.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Items per page (20-200, default 200).
     */
    public function withPageSize(int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

        return $self;
    }
}
