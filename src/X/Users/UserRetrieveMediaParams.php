<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Users;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get media tweets by a user.
 *
 * @see XTwitterScraper\Services\X\UsersService::retrieveMedia()
 *
 * @phpstan-type UserRetrieveMediaParamsShape = array{cursor?: string|null}
 */
final class UserRetrieveMediaParams implements BaseModel
{
    /** @use SdkModel<UserRetrieveMediaParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Pagination cursor for media tweets.
     */
    #[Optional]
    public ?string $cursor;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $cursor = null): self
    {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Pagination cursor for media tweets.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }
}
