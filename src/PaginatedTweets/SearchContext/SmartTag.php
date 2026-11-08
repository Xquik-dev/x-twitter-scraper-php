<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\PaginatedTweets\SearchContext;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type SmartTagShape = array{
 *   id: string,
 *   active?: bool|null,
 *   supportsOhlc?: bool|null,
 * }
 */
final class SmartTag implements BaseModel
{
    /** @use SdkModel<SmartTagShape> */
    use SdkModel;

    /**
     * The ticker X matched.
     */
    #[Required]
    public string $id;

    /**
     * Whether X lists the ticker as active.
     */
    #[Optional]
    public ?bool $active;

    /**
     * Whether X charts the ticker with open, high, low & close prices.
     */
    #[Optional]
    public ?bool $supportsOhlc;

    /**
     * `new SmartTag()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SmartTag::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SmartTag)->withId(...)
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
    public static function with(string $id, ?bool $active = null, ?bool $supportsOhlc = null): self
    {
        $self = new self;

        $self['id'] = $id;

        null !== $active && $self['active'] = $active;
        null !== $supportsOhlc && $self['supportsOhlc'] = $supportsOhlc;

        return $self;
    }

    /**
     * The ticker X matched.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Whether X lists the ticker as active.
     */
    public function withActive(?bool $active): self
    {
        $self = clone $this;
        $self['active'] = $active;

        return $self;
    }

    /**
     * Whether X charts the ticker with open, high, low & close prices.
     */
    public function withSupportsOhlc(?bool $supportsOhlc): self
    {
        $self = clone $this;
        $self['supportsOhlc'] = $supportsOhlc;

        return $self;
    }
}
