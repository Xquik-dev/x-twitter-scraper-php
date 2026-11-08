<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks\Withheld;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type EvidenceShape = array{
 *   countries: list<string>,
 * }
 */
final class Evidence implements BaseModel
{
    /** @use SdkModel<EvidenceShape> */
    use SdkModel;

    /**
     * Country codes as X gives them.
     *
     * @var list<string> $countries
     */
    #[Required(list: 'string')]
    public array $countries;

    /**
     * `new Evidence()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Evidence::with(countries: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Evidence)->withCountries(...)
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
     * @param list<string> $countries
     */
    public static function with(array $countries): self
    {
        $self = new self;

        $self['countries'] = $countries;

        return $self;
    }

    /**
     * Country codes as X gives them.
     *
     * @param list<string> $countries
     */
    public function withCountries(array $countries): self
    {
        $self = clone $this;
        $self['countries'] = $countries;

        return $self;
    }
}
