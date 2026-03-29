<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Users;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Search users by name or username.
 *
 * @see XTwitterScraper\Services\X\UsersService::retrieveSearch()
 *
 * @phpstan-type UserRetrieveSearchParamsShape = array{
 *   q: string, cursor?: string|null
 * }
 */
final class UserRetrieveSearchParams implements BaseModel
{
    /** @use SdkModel<UserRetrieveSearchParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Search query.
     */
    #[Required]
    public string $q;

    /**
     * Pagination cursor.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * `new UserRetrieveSearchParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserRetrieveSearchParams::with(q: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserRetrieveSearchParams)->withQ(...)
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
     */
    public static function with(string $q, ?string $cursor = null): self
    {
        $self = new self;

        $self['q'] = $q;

        null !== $cursor && $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Search query.
     */
    public function withQ(string $q): self
    {
        $self = clone $this;
        $self['q'] = $q;

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
}
