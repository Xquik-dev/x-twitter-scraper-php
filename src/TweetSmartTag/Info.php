<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetSmartTag;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type InfoShape = array{
 *   info?: \XTwitterScraper\TweetSmartTag\Info\Info|array<string,mixed>|null,
 * }
 */
final class Info implements BaseModel
{
    /** @use SdkModel<InfoShape> */
    use SdkModel;

    #[Optional]
    public ?Info\Info $info;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Info\Info|array<string,mixed>|null $info
     */
    public static function with(Info\Info|array|null $info = null): self
    {
        $self = new self;

        null !== $info && $self['info'] = $info;

        return $self;
    }

    /**
     * @param Info\Info|array<string,mixed>|null $info
     */
    public function withInfo(Info\Info|array|null $info): self
    {
        $self = clone $this;
        $self['info'] = $info;

        return $self;
    }
}
