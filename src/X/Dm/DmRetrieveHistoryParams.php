<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Dm;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get DM conversation history.
 *
 * @see XTwitterScraper\Services\X\DmService::retrieveHistory()
 *
 * @phpstan-type DmRetrieveHistoryParamsShape = array{
 *   account: string, cursor?: string|null, maxID?: string|null
 * }
 */
final class DmRetrieveHistoryParams implements BaseModel
{
    /** @use SdkModel<DmRetrieveHistoryParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * X handle (without the `@` prefix) of the connected X account used to read the conversation. The account must be a participant in the conversation.
     */
    #[Required]
    public string $account;

    /**
     * Pagination cursor for DM history.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Legacy pagination cursor (backward compat).
     */
    #[Optional]
    public ?string $maxID;

    /**
     * `new DmRetrieveHistoryParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DmRetrieveHistoryParams::with(account: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DmRetrieveHistoryParams)->withAccount(...)
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
    public static function with(
        string $account,
        ?string $cursor = null,
        ?string $maxID = null
    ): self {
        $self = new self;

        $self['account'] = $account;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $maxID && $self['maxID'] = $maxID;

        return $self;
    }

    /**
     * X handle (without the `@` prefix) of the connected X account used to read the conversation. The account must be a participant in the conversation.
     */
    public function withAccount(string $account): self
    {
        $self = clone $this;
        $self['account'] = $account;

        return $self;
    }

    /**
     * Pagination cursor for DM history.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Legacy pagination cursor (backward compat).
     */
    public function withMaxID(string $maxID): self
    {
        $self = clone $this;
        $self['maxID'] = $maxID;

        return $self;
    }
}
