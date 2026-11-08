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
 * Mutes a user through a connected X account. The user's posts leave that account's timelines, and X doesn't tell the user.
 *
 * @see XTwitterScraper\Services\X\UsersService::mute()
 *
 * @phpstan-type UserMuteParamsShape = array{
 *   account: string,
 * }
 */
final class UserMuteParams implements BaseModel
{
    /** @use SdkModel<UserMuteParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * X account identifier (@username or account ID).
     */
    #[Required]
    public string $account;

    /**
     * `new UserMuteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserMuteParams::with(account: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserMuteParams)->withAccount(...)
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
