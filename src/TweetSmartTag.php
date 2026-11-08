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
use XTwitterScraper\TweetSmartTag\Info;

/**
 * @phpstan-type TweetSmartTagShape = array{
 *   id?: string|null,
 *   info?: Info|array<string,mixed>|null,
 * }
 */
final class TweetSmartTag implements BaseModel
{
    /** @use SdkModel<TweetSmartTagShape> */
    use SdkModel;

    /**
     * X's ID for the SmartTag.
     */
    #[Optional]
    public ?string $id;

    #[Optional]
    public ?Info $info;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Info|array<string,mixed>|null $info
     */
    public static function with(?string $id = null, Info|array|null $info = null): self
    {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $info && $self['info'] = $info;

        return $self;
    }

    /**
     * X's ID for the SmartTag.
     */
    public function withId(?string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param Info|array<string,mixed>|null $info
     */
    public function withInfo(Info|array|null $info): self
    {
        $self = clone $this;
        $self['info'] = $info;

        return $self;
    }
}
