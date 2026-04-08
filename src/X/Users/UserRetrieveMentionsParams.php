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
     * Pagination cursor for mentions.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Unix timestamp - return mentions after this time.
     */
    #[Optional]
    public ?string $sinceTime;

    /**
     * Unix timestamp - return mentions before this time.
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
     * Pagination cursor for mentions.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Unix timestamp - return mentions after this time.
     */
    public function withSinceTime(string $sinceTime): self
    {
        $self = clone $this;
        $self['sinceTime'] = $sinceTime;

        return $self;
    }

    /**
     * Unix timestamp - return mentions before this time.
     */
    public function withUntilTime(string $untilTime): self
    {
        $self = clone $this;
        $self['untilTime'] = $untilTime;

        return $self;
    }
}
