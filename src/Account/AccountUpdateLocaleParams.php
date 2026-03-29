<?php

declare(strict_types=1);

namespace XTwitterScraper\Account;

use XTwitterScraper\Account\AccountUpdateLocaleParams\Locale;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Update account locale.
 *
 * @see XTwitterScraper\Services\AccountService::updateLocale()
 *
 * @phpstan-type AccountUpdateLocaleParamsShape = array{
 *   locale: Locale|value-of<Locale>
 * }
 */
final class AccountUpdateLocaleParams implements BaseModel
{
    /** @use SdkModel<AccountUpdateLocaleParamsShape> */
    use SdkModel;
    use SdkParams;

    /** @var value-of<Locale> $locale */
    #[Required(enum: Locale::class)]
    public string $locale;

    /**
     * `new AccountUpdateLocaleParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AccountUpdateLocaleParams::with(locale: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AccountUpdateLocaleParams)->withLocale(...)
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
     *
     * @param Locale|value-of<Locale> $locale
     */
    public static function with(Locale|string $locale): self
    {
        $self = new self;

        $self['locale'] = $locale;

        return $self;
    }

    /**
     * @param Locale|value-of<Locale> $locale
     */
    public function withLocale(Locale|string $locale): self
    {
        $self = clone $this;
        $self['locale'] = $locale;

        return $self;
    }
}
