<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Users;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get recent tweets by a user.
 *
 * @see XTwitterScraper\Services\X\UsersService::retrieveTweets()
 *
 * @phpstan-type UserRetrieveTweetsParamsShape = array{
 *   cursor?: string|null,
 *   includeParentTweet?: bool|null,
 *   includeReplies?: bool|null,
 * }
 */
final class UserRetrieveTweetsParams implements BaseModel
{
    /** @use SdkModel<UserRetrieveTweetsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Pagination cursor for user tweets.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Include parent tweet for replies.
     */
    #[Optional]
    public ?bool $includeParentTweet;

    /**
     * Include reply tweets.
     */
    #[Optional]
    public ?bool $includeReplies;

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
        ?bool $includeParentTweet = null,
        ?bool $includeReplies = null,
    ): self {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $includeParentTweet && $self['includeParentTweet'] = $includeParentTweet;
        null !== $includeReplies && $self['includeReplies'] = $includeReplies;

        return $self;
    }

    /**
     * Pagination cursor for user tweets.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Include parent tweet for replies.
     */
    public function withIncludeParentTweet(bool $includeParentTweet): self
    {
        $self = clone $this;
        $self['includeParentTweet'] = $includeParentTweet;

        return $self;
    }

    /**
     * Include reply tweets.
     */
    public function withIncludeReplies(bool $includeReplies): self
    {
        $self = clone $this;
        $self['includeReplies'] = $includeReplies;

        return $self;
    }
}
