<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Accounts;

use XTwitterScraper\Core\Concerns\SdkUnion;
use XTwitterScraper\Core\Conversion\Contracts\Converter;
use XTwitterScraper\Core\Conversion\Contracts\ConverterSource;
use XTwitterScraper\X\Accounts\AccountNewResponse\XAccountConnectionAttemptPending;
use XTwitterScraper\X\Accounts\AccountNewResponse\XAccountConnectionChallenge;

/**
 * The account once the sign-in finishes, or the pending attempt or email code challenge while it continues.
 *
 * @phpstan-import-type AccountReauthResponseShape from \XTwitterScraper\X\Accounts\AccountReauthResponse
 * @phpstan-import-type XAccountConnectionAttemptPendingShape from \XTwitterScraper\X\Accounts\AccountNewResponse\XAccountConnectionAttemptPending
 * @phpstan-import-type XAccountConnectionChallengeShape from \XTwitterScraper\X\Accounts\AccountNewResponse\XAccountConnectionChallenge
 *
 * @phpstan-type AccountReauthResponseUnionVariants = AccountReauthResponse|XAccountConnectionAttemptPending|XAccountConnectionChallenge
 * @phpstan-type AccountReauthResponseUnionShape = AccountReauthResponseUnionVariants|AccountReauthResponseShape|XAccountConnectionAttemptPendingShape|XAccountConnectionChallengeShape
 */
final class AccountReauthResponseUnion implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            AccountReauthResponse::class,
            XAccountConnectionAttemptPending::class,
            XAccountConnectionChallenge::class,
        ];
    }
}
