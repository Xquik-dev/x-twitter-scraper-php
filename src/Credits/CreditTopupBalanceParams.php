<?php

declare(strict_types=1);

namespace XTwitterScraper\Credits;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Top up credits balance.
 *
 * @see XTwitterScraper\Services\CreditsService::topupBalance()
 *
 * @phpstan-type CreditTopupBalanceParamsShape = array{amount: int}
 */
final class CreditTopupBalanceParams implements BaseModel
{
    /** @use SdkModel<CreditTopupBalanceParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Amount to top up in credits.
     */
    #[Required]
    public int $amount;

    /**
     * `new CreditTopupBalanceParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CreditTopupBalanceParams::with(amount: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CreditTopupBalanceParams)->withAmount(...)
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
    public static function with(int $amount): self
    {
        $self = new self;

        $self['amount'] = $amount;

        return $self;
    }

    /**
     * Amount to top up in credits.
     */
    public function withAmount(int $amount): self
    {
        $self = clone $this;
        $self['amount'] = $amount;

        return $self;
    }
}
