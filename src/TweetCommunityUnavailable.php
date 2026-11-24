<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TweetCommunityUnavailableShape = array{
 *   reason: string,
 * }
 */
final class TweetCommunityUnavailable implements BaseModel
{
    /** @use SdkModel<TweetCommunityUnavailableShape> */
    use SdkModel;

    /**
     * X's reason, as X writes it.
     */
    #[Required]
    public string $reason;

    /**
     * `new TweetCommunityUnavailable()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetCommunityUnavailable::with(reason: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetCommunityUnavailable)->withReason(...)
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
    public static function with(string $reason): self
    {
        $self = new self;

        $self['reason'] = $reason;

        return $self;
    }

    /**
     * X's reason, as X writes it.
     */
    public function withReason(string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }
}
