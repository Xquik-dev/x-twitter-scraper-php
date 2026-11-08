<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\EmbeddedTweet;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type QuotedTweetUnavailableShape = array{
 *   reason: string,
 * }
 */
final class QuotedTweetUnavailable implements BaseModel
{
    /** @use SdkModel<QuotedTweetUnavailableShape> */
    use SdkModel;

    /**
     * X's reason, such as `Suspended` for a suspended author or `Protected` for an author who protects their posts.
     */
    #[Required]
    public string $reason;

    /**
     * `new QuotedTweetUnavailable()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * QuotedTweetUnavailable::with(reason: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new QuotedTweetUnavailable)->withReason(...)
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
     * X's reason, such as `Suspended` for a suspended author or `Protected` for an author who protects their posts.
     */
    public function withReason(string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }
}
