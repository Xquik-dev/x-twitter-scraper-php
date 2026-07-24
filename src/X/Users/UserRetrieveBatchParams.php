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
 * Look up multiple users by IDs in one call.
 *
 * @see XTwitterScraper\Services\X\UsersService::retrieveBatch()
 *
 * @phpstan-type UserRetrieveBatchParamsShape = array{ids: string}
 */
final class UserRetrieveBatchParams implements BaseModel
{
    /** @use SdkModel<UserRetrieveBatchParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Comma-separated numeric user IDs (1-100 values). Duplicate IDs are ignored while preserving first-seen order.
     */
    #[Required]
    public string $ids;

    /**
     * `new UserRetrieveBatchParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserRetrieveBatchParams::with(ids: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserRetrieveBatchParams)->withIDs(...)
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
    public static function with(string $ids): self
    {
        $self = new self;

        $self['ids'] = $ids;

        return $self;
    }

    /**
     * Comma-separated numeric user IDs (1-100 values). Duplicate IDs are ignored while preserving first-seen order.
     */
    public function withIDs(string $ids): self
    {
        $self = clone $this;
        $self['ids'] = $ids;

        return $self;
    }
}
