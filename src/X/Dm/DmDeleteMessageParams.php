<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Dm;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Deletes 1 DM from the account's side. The other person keeps it. Success means the DM is gone from the account's conversation. A DM that stays gets 422 `x_dm_not_deleted`, and Xquik charges nothing.
 *
 * @see XTwitterScraper\Services\X\DmService::deleteMessage()
 *
 * @phpstan-type DmDeleteMessageParamsShape = array{
 *   account: string,
 * }
 */
final class DmDeleteMessageParams implements BaseModel
{
    /** @use SdkModel<DmDeleteMessageParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Connected X account (@username or ID) that sees the DM.
     */
    #[Required]
    public string $account;

    /**
     * `new DmDeleteMessageParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DmDeleteMessageParams::with(account: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DmDeleteMessageParams)->withAccount(...)
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
     * Connected X account (@username or ID) that sees the DM.
     */
    public function withAccount(string $account): self
    {
        $self = clone $this;
        $self['account'] = $account;

        return $self;
    }
}
