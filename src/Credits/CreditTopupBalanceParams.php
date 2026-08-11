<?php

declare(strict_types=1);

namespace XTwitterScraper\Credits;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Create a hosted checkout only after the user confirms. The request never completes payment or adds credits.
 *
 * @see XTwitterScraper\Services\CreditsService::topupBalance()
 *
 * @phpstan-type CreditTopupBalanceParamsShape = array{
 *   dollars: int, locale?: string|null
 * }
 */
final class CreditTopupBalanceParams implements BaseModel
{
    /** @use SdkModel<CreditTopupBalanceParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Amount to top up in US dollars. Minimum 10.
     */
    #[Required]
    public int $dollars;

    /**
     * Optional checkout locale. Defaults to en.
     */
    #[Optional]
    public ?string $locale;

    /**
     * `new CreditTopupBalanceParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CreditTopupBalanceParams::with(dollars: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CreditTopupBalanceParams)->withDollars(...)
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
    public static function with(int $dollars, ?string $locale = null): self
    {
        $self = new self;

        $self['dollars'] = $dollars;

        null !== $locale && $self['locale'] = $locale;

        return $self;
    }

    /**
     * Amount to top up in US dollars. Minimum 10.
     */
    public function withDollars(int $dollars): self
    {
        $self = clone $this;
        $self['dollars'] = $dollars;

        return $self;
    }

    /**
     * Optional checkout locale. Defaults to en.
     */
    public function withLocale(string $locale): self
    {
        $self = clone $this;
        $self['locale'] = $locale;

        return $self;
    }
}
