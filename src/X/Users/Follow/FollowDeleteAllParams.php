<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Users\Follow;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Unfollow user.
 *
 * @see XTwitterScraper\Services\X\Users\FollowService::deleteAll()
 *
 * @phpstan-type FollowDeleteAllParamsShape = array{
 *   account: string, idempotencyKey: string
 * }
 */
final class FollowDeleteAllParams implements BaseModel
{
    /** @use SdkModel<FollowDeleteAllParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * X account identifier (@username or account ID).
     */
    #[Required]
    public string $account;

    #[Required]
    public string $idempotencyKey;

    /**
     * `new FollowDeleteAllParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FollowDeleteAllParams::with(account: ..., idempotencyKey: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FollowDeleteAllParams)->withAccount(...)->withIdempotencyKey(...)
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
    public static function with(string $account, string $idempotencyKey): self
    {
        $self = new self;

        $self['account'] = $account;
        $self['idempotencyKey'] = $idempotencyKey;

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

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }
}
