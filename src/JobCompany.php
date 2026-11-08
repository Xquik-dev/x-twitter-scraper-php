<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type JobCompanyShape = array{
 *   id: string,
 *   name?: string|null,
 *   logoUrl?: string|null,
 * }
 */
final class JobCompany implements BaseModel
{
    /** @use SdkModel<JobCompanyShape> */
    use SdkModel;

    /**
     * X company profile ID.
     */
    #[Required]
    public string $id;

    /**
     * Company name.
     */
    #[Optional]
    public ?string $name;

    /**
     * Company logo URL.
     */
    #[Optional]
    public ?string $logoUrl;

    /**
     * `new JobCompany()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * JobCompany::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new JobCompany)->withId(...)
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
    public static function with(string $id, ?string $name = null, ?string $logoUrl = null): self
    {
        $self = new self;

        $self['id'] = $id;

        null !== $name && $self['name'] = $name;
        null !== $logoUrl && $self['logoUrl'] = $logoUrl;

        return $self;
    }

    /**
     * X company profile ID.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Company name.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Company logo URL.
     */
    public function withLogoUrl(?string $logoUrl): self
    {
        $self = clone $this;
        $self['logoUrl'] = $logoUrl;

        return $self;
    }
}
