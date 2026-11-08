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
 * @see XTwitterScraper\Services\X\AccountsService::bulkRetry()
 *
 * @phpstan-type AccountBulkRetryParamsShape = array{
 *   accountIDs?: list<mixed>|null,
 * }
 */
final class AccountBulkRetryParams implements BaseModel
{
    /** @use SdkModel<AccountBulkRetryParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * IDs of the X accounts to retry. Accounts that failed for another reason, or belong to someone else, stay as they are.
     *
     * @var list<mixed>|null $accountIDs
     */
    #[Optional('accountIds', list: 'mixed')]
    public ?array $accountIDs;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<mixed>|null $accountIDs
     */
    public static function with(?array $accountIDs = null): self
    {
        $self = new self;

        null !== $accountIDs && $self['accountIDs'] = $accountIDs;

        return $self;
    }

    /**
     * IDs of the X accounts to retry. Accounts that failed for another reason, or belong to someone else, stay as they are.
     *
     * @param list<mixed>|null $accountIDs
     */
    public function withAccountIDs(?array $accountIDs): self
    {
        $self = clone $this;
        $self['accountIDs'] = $accountIDs;

        return $self;
    }
}
