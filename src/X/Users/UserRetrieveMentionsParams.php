<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Users;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get tweets mentioning a user.
 *
 * @see XTwitterScraper\Services\X\UsersService::retrieveMentions()
 *
 * @phpstan-type UserRetrieveMentionsParamsShape = array{
 *   cursor?: string|null, sinceTime?: string|null, untilTime?: string|null
 * }
 */
final class UserRetrieveMentionsParams implements BaseModel
{
    /** @use SdkModel<UserRetrieveMentionsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Pagination cursor.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Unix timestamp - filter after.
     */
    #[Optional]
    public ?string $sinceTime;

    /**
     * Unix timestamp - filter before.
     */
    #[Optional]
    public ?string $untilTime;

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
        ?string $sinceTime = null,
        ?string $untilTime = null
    ): self {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $sinceTime && $self['sinceTime'] = $sinceTime;
        null !== $untilTime && $self['untilTime'] = $untilTime;

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
     * Unix timestamp - filter after.
     */
    public function withSinceTime(string $sinceTime): self
    {
        $self = clone $this;
        $self['sinceTime'] = $sinceTime;

        return $self;
    }

    /**
     * Unix timestamp - filter before.
     */
    public function withUntilTime(string $untilTime): self
    {
        $self = clone $this;
        $self['untilTime'] = $untilTime;

        return $self;
    }
}
