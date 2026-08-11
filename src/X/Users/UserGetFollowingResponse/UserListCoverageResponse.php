<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Users\UserGetFollowingResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\UserProfile;
use XTwitterScraper\X\Users\UserGetFollowingResponse\UserListCoverageResponse\Diagnostic;

/**
 * Paginated user profiles. No-mode follower, following, and verified follower requests merge independent views automatically. Response fields, page size, aliases, filters, and per-returned-profile billing stay unchanged. Existing unprefixed cursors retain legacy behavior. Follow next_cursor while has_next_page is true.
 *
 * @phpstan-import-type UserProfileShape from \XTwitterScraper\UserProfile
 * @phpstan-import-type DiagnosticShape from \XTwitterScraper\X\Users\UserGetFollowingResponse\UserListCoverageResponse\Diagnostic
 *
 * @phpstan-type UserListCoverageResponseShape = array{
 *   hasNextPage: bool,
 *   nextCursor: string,
 *   users: list<UserProfile|UserProfileShape>,
 *   diagnostic: Diagnostic|DiagnosticShape,
 * }
 */
final class UserListCoverageResponse implements BaseModel
{
    /** @use SdkModel<UserListCoverageResponseShape> */
    use SdkModel;

    #[Required('has_next_page')]
    public bool $hasNextPage;

    #[Required('next_cursor')]
    public string $nextCursor;

    /** @var list<UserProfile> $users */
    #[Required(list: UserProfile::class)]
    public array $users;

    /**
     * Coverage evidence across parallel relationship strategies.
     */
    #[Required]
    public Diagnostic $diagnostic;

    /**
     * `new UserListCoverageResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserListCoverageResponse::with(
     *   hasNextPage: ..., nextCursor: ..., users: ..., diagnostic: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserListCoverageResponse)
     *   ->withHasNextPage(...)
     *   ->withNextCursor(...)
     *   ->withUsers(...)
     *   ->withDiagnostic(...)
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
     * @param Diagnostic|DiagnosticShape $diagnostic
     */
    public static function with(
        bool $hasNextPage,
        string $nextCursor,
        array $users,
        Diagnostic|array $diagnostic,
    ): self {
        $self = new self;

        $self['hasNextPage'] = $hasNextPage;
        $self['nextCursor'] = $nextCursor;
        $self['users'] = $users;
        $self['diagnostic'] = $diagnostic;

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
     * Coverage evidence across parallel relationship strategies.
     *
     * @param Diagnostic|DiagnosticShape $diagnostic
     */
    public function withDiagnostic(Diagnostic|array $diagnostic): self
    {
        $self = clone $this;
        $self['diagnostic'] = $diagnostic;

        return $self;
    }
}
