<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Accounts;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type XAccountShape from XAccount
 *
 * @phpstan-type AccountListResponseShape = array{
 *   accounts: list<XAccount|XAccountShape>,
 *   hasMore?: bool|null,
 *   nextCursor?: string|null,
 * }
 */
final class AccountListResponse implements BaseModel
{
    /** @use SdkModel<AccountListResponseShape> */
    use SdkModel;

    /** @var list<XAccount> $accounts */
    #[Required(list: XAccount::class)]
    public array $accounts;

    /**
     * Present on cursor-paginated responses.
     */
    #[Optional]
    public ?bool $hasMore;

    /**
     * Pass unchanged as cursor when hasMore is true.
     */
    #[Optional]
    public ?string $nextCursor;

    /**
     * `new AccountListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AccountListResponse::with(accounts: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AccountListResponse)->withAccounts(...)
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
     * @param list<XAccount|XAccountShape> $accounts
     */
    public static function with(array $accounts, ?bool $hasMore = null, ?string $nextCursor = null): self
    {
        $self = new self;

        $self['accounts'] = $accounts;

        null !== $hasMore && $self['hasMore'] = $hasMore;

        null !== $nextCursor && $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * @param list<XAccount|XAccountShape> $accounts
     */
    public function withAccounts(array $accounts): self
    {
        $self = clone $this;
        $self['accounts'] = $accounts;

        return $self;
    }

    /**
     * Present on cursor-paginated responses.
     */
    public function withHasMore(?bool $hasMore): self
    {
        $self = clone $this;
        $self['hasMore'] = $hasMore;

        return $self;
    }

    /**
     * Pass unchanged as cursor when hasMore is true.
     */
    public function withNextCursor(?string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }
}
