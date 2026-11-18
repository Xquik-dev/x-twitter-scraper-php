<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type BatchUserTweetsShape = array{
 *   tweets: list<SearchTweet2|array<string,mixed>>,
 *   hasNextPage: bool,
 *   nextCursor: string,
 *   unavailableIDs: list<string>,
 *   notFoundIDs: list<string>,
 *   suspendedIDs: list<string>,
 *   protectedIDs: list<string>,
 *   unprocessedIDs: list<string>,
 * }
 */
final class BatchUserTweets implements BaseModel
{
    /** @use SdkModel<BatchUserTweetsShape> */
    use SdkModel;

    /**
     * @var list<SearchTweet2> $tweets
     */
    #[Required(list: SearchTweet2::class)]
    public array $tweets;

    /**
     * Always false. The answer holds every post in 1 page.
     */
    #[Required('has_next_page')]
    public bool $hasNextPage;

    /**
     * Always empty. The answer holds every post in 1 page.
     */
    #[Required('next_cursor')]
    public string $nextCursor;

    /**
     * Users with no account on X or with protected posts, in first-seen request order. They cost nothing. notFoundIDs, suspendedIDs and protectedIDs split them by X's answer.
     *
     * @var list<string> $unavailableIDs
     */
    #[Required('unavailable_ids', list: 'string')]
    public array $unavailableIDs;

    /**
     * The unavailable users no account holds, as X answers for an account that was deactivated or deleted, in first-seen request order.
     *
     * @var list<string> $notFoundIDs
     */
    #[Required('not_found_ids', list: 'string')]
    public array $notFoundIDs;

    /**
     * The unavailable users X suspended, in first-seen request order.
     *
     * @var list<string> $suspendedIDs
     */
    #[Required('suspended_ids', list: 'string')]
    public array $suspendedIDs;

    /**
     * The unavailable users whose posts only approved followers see, in first-seen request order.
     *
     * @var list<string> $protectedIDs
     */
    #[Required('protected_ids', list: 'string')]
    public array $protectedIDs;

    /**
     * Users the call did not read, in first-seen request order. Their read failed, the call ran out of time or credits ran out. They cost nothing. Send them again.
     *
     * @var list<string> $unprocessedIDs
     */
    #[Required('unprocessed_ids', list: 'string')]
    public array $unprocessedIDs;

    /**
     * `new BatchUserTweets()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BatchUserTweets::with(tweets: ..., hasNextPage: ..., nextCursor: ..., unavailableIDs: ..., notFoundIDs: ..., suspendedIDs: ..., protectedIDs: ..., unprocessedIDs: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BatchUserTweets)->withTweets(...)->withHasNextPage(...)->withNextCursor(...)->withUnavailableIDs(...)->withNotFoundIDs(...)->withSuspendedIDs(...)->withProtectedIDs(...)->withUnprocessedIDs(...)
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
     * @param list<SearchTweet2|array<string,mixed>> $tweets
     * @param list<string> $unavailableIDs
     * @param list<string> $notFoundIDs
     * @param list<string> $suspendedIDs
     * @param list<string> $protectedIDs
     * @param list<string> $unprocessedIDs
     */
    public static function with(array $tweets, bool $hasNextPage, string $nextCursor, array $unavailableIDs, array $notFoundIDs, array $suspendedIDs, array $protectedIDs, array $unprocessedIDs): self
    {
        $self = new self;

        $self['tweets'] = $tweets;
        $self['hasNextPage'] = $hasNextPage;
        $self['nextCursor'] = $nextCursor;
        $self['unavailableIDs'] = $unavailableIDs;
        $self['notFoundIDs'] = $notFoundIDs;
        $self['suspendedIDs'] = $suspendedIDs;
        $self['protectedIDs'] = $protectedIDs;
        $self['unprocessedIDs'] = $unprocessedIDs;

        return $self;
    }

    /**
     * @param list<SearchTweet2|array<string,mixed>> $tweets
     */
    public function withTweets(array $tweets): self
    {
        $self = clone $this;
        $self['tweets'] = $tweets;

        return $self;
    }

    /**
     * Always false. The answer holds every post in 1 page.
     */
    public function withHasNextPage(bool $hasNextPage): self
    {
        $self = clone $this;
        $self['hasNextPage'] = $hasNextPage;

        return $self;
    }

    /**
     * Always empty. The answer holds every post in 1 page.
     */
    public function withNextCursor(string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * Users with no account on X or with protected posts, in first-seen request order. They cost nothing. notFoundIDs, suspendedIDs and protectedIDs split them by X's answer.
     *
     * @param list<string> $unavailableIDs
     */
    public function withUnavailableIDs(array $unavailableIDs): self
    {
        $self = clone $this;
        $self['unavailableIDs'] = $unavailableIDs;

        return $self;
    }

    /**
     * The unavailable users no account holds, as X answers for an account that was deactivated or deleted, in first-seen request order.
     *
     * @param list<string> $notFoundIDs
     */
    public function withNotFoundIDs(array $notFoundIDs): self
    {
        $self = clone $this;
        $self['notFoundIDs'] = $notFoundIDs;

        return $self;
    }

    /**
     * The unavailable users X suspended, in first-seen request order.
     *
     * @param list<string> $suspendedIDs
     */
    public function withSuspendedIDs(array $suspendedIDs): self
    {
        $self = clone $this;
        $self['suspendedIDs'] = $suspendedIDs;

        return $self;
    }

    /**
     * The unavailable users whose posts only approved followers see, in first-seen request order.
     *
     * @param list<string> $protectedIDs
     */
    public function withProtectedIDs(array $protectedIDs): self
    {
        $self = clone $this;
        $self['protectedIDs'] = $protectedIDs;

        return $self;
    }

    /**
     * Users the call did not read, in first-seen request order. Their read failed, the call ran out of time or credits ran out. They cost nothing. Send them again.
     *
     * @param list<string> $unprocessedIDs
     */
    public function withUnprocessedIDs(array $unprocessedIDs): self
    {
        $self = clone $this;
        $self['unprocessedIDs'] = $unprocessedIDs;

        return $self;
    }
}
