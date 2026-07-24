<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Users;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\UserProfile;

/**
 * Batch user lookup results. Duplicate requested IDs are ignored while preserving first-seen order. unavailable_ids identifies processed IDs with no returned profile. unprocessed_ids identifies IDs skipped when available credits limit processing.
 *
 * @phpstan-import-type UserProfileShape from \XTwitterScraper\UserProfile
 *
 * @phpstan-type UserGetBatchResponseShape = array{
 *   hasNextPage: bool,
 *   nextCursor: string,
 *   processedCount: int,
 *   requestedCount: int,
 *   returnedCount: int,
 *   unavailableIDs: list<string>,
 *   unprocessedIDs: list<string>,
 *   users: list<UserProfile|UserProfileShape>,
 * }
 */
final class UserGetBatchResponse implements BaseModel
{
    /** @use SdkModel<UserGetBatchResponseShape> */
    use SdkModel;

    /**
     * Batch lookups never paginate.
     */
    #[Required('has_next_page')]
    public bool $hasNextPage = false;

    /**
     * Empty because batch lookups never paginate.
     */
    #[Required('next_cursor')]
    public string $nextCursor;

    /**
     * Number of requested IDs included in the lookup.
     */
    #[Required('processed_count')]
    public int $processedCount;

    /**
     * Number of unique IDs requested.
     */
    #[Required('requested_count')]
    public int $requestedCount;

    /**
     * Number of user profiles returned and charged.
     */
    #[Required('returned_count')]
    public int $returnedCount;

    /**
     * Processed IDs with no returned profile, in first-seen request order.
     *
     * @var list<string> $unavailableIDs
     */
    #[Required('unavailable_ids', list: 'string')]
    public array $unavailableIDs;

    /**
     * Requested IDs skipped because available credits limited processing. Retry these IDs after adding credits.
     *
     * @var list<string> $unprocessedIDs
     */
    #[Required('unprocessed_ids', list: 'string')]
    public array $unprocessedIDs;

    /** @var list<UserProfile> $users */
    #[Required(list: UserProfile::class)]
    public array $users;

    /**
     * `new UserGetBatchResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserGetBatchResponse::with(
     *   nextCursor: ...,
     *   processedCount: ...,
     *   requestedCount: ...,
     *   returnedCount: ...,
     *   unavailableIDs: ...,
     *   unprocessedIDs: ...,
     *   users: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserGetBatchResponse)
     *   ->withNextCursor(...)
     *   ->withProcessedCount(...)
     *   ->withRequestedCount(...)
     *   ->withReturnedCount(...)
     *   ->withUnavailableIDs(...)
     *   ->withUnprocessedIDs(...)
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
     * @param list<string> $unavailableIDs
     * @param list<string> $unprocessedIDs
     * @param list<UserProfile|UserProfileShape> $users
     */
    public static function with(
        string $nextCursor,
        int $processedCount,
        int $requestedCount,
        int $returnedCount,
        array $unavailableIDs,
        array $unprocessedIDs,
        array $users,
    ): self {
        $self = new self;

        $self['nextCursor'] = $nextCursor;
        $self['processedCount'] = $processedCount;
        $self['requestedCount'] = $requestedCount;
        $self['returnedCount'] = $returnedCount;
        $self['unavailableIDs'] = $unavailableIDs;
        $self['unprocessedIDs'] = $unprocessedIDs;
        $self['users'] = $users;

        return $self;
    }

    /**
     * Batch lookups never paginate.
     */
    public function withHasNextPage(bool $hasNextPage): self
    {
        $self = clone $this;
        $self['hasNextPage'] = $hasNextPage;

        return $self;
    }

    /**
     * Empty because batch lookups never paginate.
     */
    public function withNextCursor(string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * Number of requested IDs included in the lookup.
     */
    public function withProcessedCount(int $processedCount): self
    {
        $self = clone $this;
        $self['processedCount'] = $processedCount;

        return $self;
    }

    /**
     * Number of unique IDs requested.
     */
    public function withRequestedCount(int $requestedCount): self
    {
        $self = clone $this;
        $self['requestedCount'] = $requestedCount;

        return $self;
    }

    /**
     * Number of user profiles returned and charged.
     */
    public function withReturnedCount(int $returnedCount): self
    {
        $self = clone $this;
        $self['returnedCount'] = $returnedCount;

        return $self;
    }

    /**
     * Processed IDs with no returned profile, in first-seen request order.
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
     * Requested IDs skipped because available credits limited processing. Retry these IDs after adding credits.
     *
     * @param list<string> $unprocessedIDs
     */
    public function withUnprocessedIDs(array $unprocessedIDs): self
    {
        $self = clone $this;
        $self['unprocessedIDs'] = $unprocessedIDs;

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
