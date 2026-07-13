<?php

declare(strict_types=1);

namespace XTwitterScraper\X\AccountConnectionChallenges;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Submit X account email verification code.
 *
 * @see XTwitterScraper\Services\X\AccountConnectionChallengesService::submit()
 *
 * @phpstan-type AccountConnectionChallengeSubmitParamsShape = array{
 *   emailCode: string
 * }
 */
final class AccountConnectionChallengeSubmitParams implements BaseModel
{
    /** @use SdkModel<AccountConnectionChallengeSubmitParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Code sent to the account email.
     */
    #[Required('email_code')]
    public string $emailCode;

    /**
     * `new AccountConnectionChallengeSubmitParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AccountConnectionChallengeSubmitParams::with(emailCode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AccountConnectionChallengeSubmitParams)->withEmailCode(...)
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
    public static function with(string $emailCode): self
    {
        $self = new self;

        $self['emailCode'] = $emailCode;

        return $self;
    }

    /**
     * Code sent to the account email.
     */
    public function withEmailCode(string $emailCode): self
    {
        $self = clone $this;
        $self['emailCode'] = $emailCode;

        return $self;
    }
}
