<?php

declare(strict_types=1);

namespace XTwitterScraper\Credits;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get top-up billing status.
 *
 * @see XTwitterScraper\Services\CreditsService::retrieveTopupStatus()
 *
 * @phpstan-type CreditRetrieveTopupStatusParamsShape = array{sessionID: string}
 */
final class CreditRetrieveTopupStatusParams implements BaseModel
{
    /** @use SdkModel<CreditRetrieveTopupStatusParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Top-up session ID to inspect.
     */
    #[Required]
    public string $sessionID;

    /**
     * `new CreditRetrieveTopupStatusParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CreditRetrieveTopupStatusParams::with(sessionID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CreditRetrieveTopupStatusParams)->withSessionID(...)
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
    public static function with(string $sessionID): self
    {
        $self = new self;

        $self['sessionID'] = $sessionID;

        return $self;
    }

    /**
     * Top-up session ID to inspect.
     */
    public function withSessionID(string $sessionID): self
    {
        $self = clone $this;
        $self['sessionID'] = $sessionID;

        return $self;
    }
}
