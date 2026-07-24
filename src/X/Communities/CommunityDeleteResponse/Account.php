<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Communities\CommunityDeleteResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Connected account selected for the write.
 *
 * @phpstan-type AccountShape = array{id: string, username: string}
 */
final class Account implements BaseModel
{
    /** @use SdkModel<AccountShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $username;

    /**
     * `new Account()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Account::with(id: ..., username: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Account)->withID(...)->withUsername(...)
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
    public static function with(string $id, string $username): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['username'] = $username;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withUsername(string $username): self
    {
        $self = clone $this;
        $self['username'] = $username;

        return $self;
    }
}
