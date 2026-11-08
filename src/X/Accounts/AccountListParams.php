<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Accounts;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @see XTwitterScraper\Services\X\AccountsService::list()
 *
 * @phpstan-type AccountListParamsShape = array{
 *   limit?: int|null,
 *   cursor?: string|null,
 * }
 */
final class AccountListParams implements BaseModel
{
    /** @use SdkModel<AccountListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Maximum items per page, from 1 to 10,000. Default 50. A low credit balance can return fewer paid results. When it covers none, the answer is 402 insufficient_credits.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Previous nextCursor. The after alias also works. Offset pagination is not supported.
     */
    #[Optional]
    public ?string $cursor;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $limit = null, ?string $cursor = null): self
    {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $cursor && $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Maximum items per page, from 1 to 10,000. Default 50. A low credit balance can return fewer paid results. When it covers none, the answer is 402 insufficient_credits.
     */
    public function withLimit(?int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Previous nextCursor. The after alias also works. Offset pagination is not supported.
     */
    public function withCursor(?string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }
}
