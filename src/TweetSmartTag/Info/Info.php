<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetSmartTag\Info;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type InfoShape = array{
 *   active?: bool|null,
 *   name?: string|null,
 *   ticker?: string|null,
 * }
 */
final class Info implements BaseModel
{
    /** @use SdkModel<InfoShape> */
    use SdkModel;

    /**
     * Whether X marks the SmartTag active.
     */
    #[Optional]
    public ?bool $active;

    #[Optional]
    public ?string $name;

    #[Optional]
    public ?string $ticker;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?bool $active = null, ?string $name = null, ?string $ticker = null): self
    {
        $self = new self;

        null !== $active && $self['active'] = $active;
        null !== $name && $self['name'] = $name;
        null !== $ticker && $self['ticker'] = $ticker;

        return $self;
    }

    /**
     * Whether X marks the SmartTag active.
     */
    public function withActive(?bool $active): self
    {
        $self = clone $this;
        $self['active'] = $active;

        return $self;
    }

    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withTicker(?string $ticker): self
    {
        $self = clone $this;
        $self['ticker'] = $ticker;

        return $self;
    }
}
