<?php

declare(strict_types=1);

namespace XTwitterScraper\X\AccountConnectionAttempts;

use XTwitterScraper\Core\Concerns\SdkUnion;
use XTwitterScraper\Core\Conversion\Contracts\Converter;
use XTwitterScraper\Core\Conversion\Contracts\ConverterSource;
use XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionAttemptFailed;
use XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionAttemptPending;
use XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionAttemptSuccess;
use XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionChallenge;

/**
 * The connection is still in progress.
 *
 * @phpstan-import-type XAccountConnectionAttemptPendingShape from \XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionAttemptPending
 * @phpstan-import-type XAccountConnectionAttemptSuccessShape from \XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionAttemptSuccess
 * @phpstan-import-type XAccountConnectionAttemptFailedShape from \XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionAttemptFailed
 * @phpstan-import-type XAccountConnectionChallengeShape from \XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionChallenge
 *
 * @phpstan-type AccountConnectionAttemptGetResponseVariants = XAccountConnectionAttemptPending|XAccountConnectionAttemptSuccess|XAccountConnectionAttemptFailed|XAccountConnectionChallenge
 * @phpstan-type AccountConnectionAttemptGetResponseShape = AccountConnectionAttemptGetResponseVariants|XAccountConnectionAttemptPendingShape|XAccountConnectionAttemptSuccessShape|XAccountConnectionAttemptFailedShape|XAccountConnectionChallengeShape
 */
final class AccountConnectionAttemptGetResponse implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            XAccountConnectionAttemptPending::class,
            XAccountConnectionAttemptSuccess::class,
            XAccountConnectionAttemptFailed::class,
            XAccountConnectionChallenge::class,
        ];
    }
}
