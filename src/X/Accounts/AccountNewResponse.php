<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Accounts;

use XTwitterScraper\Core\Concerns\SdkUnion;
use XTwitterScraper\Core\Conversion\Contracts\Converter;
use XTwitterScraper\Core\Conversion\Contracts\ConverterSource;
use XTwitterScraper\X\Accounts\AccountNewResponse\SanitizedXAccount;
use XTwitterScraper\X\Accounts\AccountNewResponse\XAccountConnectionAttemptPending;
use XTwitterScraper\X\Accounts\AccountNewResponse\XAccountConnectionChallenge;

/**
 * Sanitized X account summary returned by connect and reauth.
 *
 * @phpstan-import-type SanitizedXAccountShape from \XTwitterScraper\X\Accounts\AccountNewResponse\SanitizedXAccount
 * @phpstan-import-type XAccountConnectionAttemptPendingShape from \XTwitterScraper\X\Accounts\AccountNewResponse\XAccountConnectionAttemptPending
 * @phpstan-import-type XAccountConnectionChallengeShape from \XTwitterScraper\X\Accounts\AccountNewResponse\XAccountConnectionChallenge
 *
 * @phpstan-type AccountNewResponseVariants = SanitizedXAccount|XAccountConnectionAttemptPending|XAccountConnectionChallenge
 * @phpstan-type AccountNewResponseShape = AccountNewResponseVariants|SanitizedXAccountShape|XAccountConnectionAttemptPendingShape|XAccountConnectionChallengeShape
 */
final class AccountNewResponse implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            SanitizedXAccount::class,
            XAccountConnectionAttemptPending::class,
            XAccountConnectionChallenge::class,
        ];
    }
}
