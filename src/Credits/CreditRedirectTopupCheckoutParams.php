<?php

declare(strict_types=1);

namespace XTwitterScraper\Credits;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Redirect to an active top-up payment page.
 *
 * @see XTwitterScraper\Services\CreditsService::redirectTopupCheckout()
 *
 * @phpstan-type CreditRedirectTopupCheckoutParamsShape = array{sessionID: string}
 */
final class CreditRedirectTopupCheckoutParams implements BaseModel
{
    /** @use SdkModel<CreditRedirectTopupCheckoutParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Billing session ID returned by the top-up billing flow.
     */
    #[Required]
    public string $sessionID;

    /**
     * `new CreditRedirectTopupCheckoutParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CreditRedirectTopupCheckoutParams::with(sessionID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CreditRedirectTopupCheckoutParams)->withSessionID(...)
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
     * Billing session ID returned by the top-up billing flow.
     */
    public function withSessionID(string $sessionID): self
    {
        $self = clone $this;
        $self['sessionID'] = $sessionID;

        return $self;
    }
}
