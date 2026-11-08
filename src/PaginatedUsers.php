<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Paginated user profiles. No-mode follower, following, and verified follower requests merge independent views automatically. Response fields, page size, aliases, filters, and per-returned-profile billing stay unchanged. Existing unprefixed cursors retain legacy behavior. Follow next_cursor while has_next_page is true.
 *
 * @phpstan-import-type UserProfileShape from UserProfile
 *
 * @phpstan-type PaginatedUsersShape = array{
 *   hasNextPage: bool,
 *   nextCursor: string,
 *   users: list<UserProfile|UserProfileShape>,
 *   filteredCount?: int|null,
 *   scanLimit?: UserListScanLimit|array<string,mixed>|null,
 *   diagnostic?: UserListCoverageDiagnostic|array<string,mixed>|null,
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
     * Whole number from 0.
     */
    #[Optional('filtered_count')]
    public ?int $filteredCount;

    /**
     * Present on the last page of a filtered automatic read that sent no maxScan, once the list scanned 100,000 profiles across its pages. That page is the list's last.
     */
    #[Optional]
    public ?UserListScanLimit $scanLimit;

    /**
     * How completely the list came back, with its counts.
     */
    #[Optional]
    public ?UserListCoverageDiagnostic $diagnostic;

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
     * @param UserListScanLimit|array<string,mixed>|null $scanLimit
     * @param UserListCoverageDiagnostic|array<string,mixed>|null $diagnostic
     */
    public static function with(
        bool $hasNextPage,
        string $nextCursor,
        array $users,
        ?int $filteredCount = null,
        UserListScanLimit|array|null $scanLimit = null,
        UserListCoverageDiagnostic|array|null $diagnostic = null
    ): self {
        $self = new self;

        $self['hasNextPage'] = $hasNextPage;
        $self['nextCursor'] = $nextCursor;
        $self['users'] = $users;

        null !== $filteredCount && $self['filteredCount'] = $filteredCount;

        null !== $scanLimit && $self['scanLimit'] = $scanLimit;

        null !== $diagnostic && $self['diagnostic'] = $diagnostic;

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

    /**
     * Whole number from 0.
     */
    public function withFilteredCount(?int $filteredCount): self
    {
        $self = clone $this;
        $self['filteredCount'] = $filteredCount;

        return $self;
    }

    /**
     * Present on the last page of a filtered automatic read that sent no maxScan, once the list scanned 100,000 profiles across its pages. That page is the list's last.
     *
     * @param UserListScanLimit|array<string,mixed>|null $scanLimit
     */
    public function withScanLimit(UserListScanLimit|array|null $scanLimit): self
    {
        $self = clone $this;
        $self['scanLimit'] = $scanLimit;

        return $self;
    }

    /**
     * How completely the list came back, with its counts.
     *
     * @param UserListCoverageDiagnostic|array<string,mixed>|null $diagnostic
     */
    public function withDiagnostic(UserListCoverageDiagnostic|array|null $diagnostic): self
    {
        $self = clone $this;
        $self['diagnostic'] = $diagnostic;

        return $self;
    }
}
