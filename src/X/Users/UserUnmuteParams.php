<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Users;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Unmutes a user through a connected X account.
 *
 * @see XTwitterScraper\Services\X\UsersService::unmute()
 *
 * @phpstan-type UserUnmuteParamsShape = array{
 *   account: string,
 * }
 */
final class UserUnmuteParams implements BaseModel
{
    /** @use SdkModel<UserUnmuteParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * X account identifier (@username or account ID).
     */
    #[Required]
    public string $account;

    /**
     * `new UserUnmuteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserUnmuteParams::with(account: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserUnmuteParams)->withAccount(...)
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
    public static function with(string $account): self
    {
        $self = new self;

        $self['account'] = $account;

        return $self;
    }

    /**
     * X account identifier (@username or account ID).
     */
    public function withAccount(string $account): self
    {
        $self = clone $this;
        $self['account'] = $account;

        return $self;
    }
}
