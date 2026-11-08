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
 * @phpstan-type TweetSubscriberBadgeShape = array{
 *   creatorID: string,
 * }
 */
final class TweetSubscriberBadge implements BaseModel
{
    /** @use SdkModel<TweetSubscriberBadgeShape> */
    use SdkModel;

    /**
     * Account ID of the creator the author subscribes to.
     */
    #[Required('creatorId')]
    public string $creatorID;

    /**
     * `new TweetSubscriberBadge()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetSubscriberBadge::with(creatorID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetSubscriberBadge)->withCreatorID(...)
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
    public static function with(string $creatorID): self
    {
        $self = new self;

        $self['creatorID'] = $creatorID;

        return $self;
    }

    /**
     * Account ID of the creator the author subscribes to.
     */
    public function withCreatorID(string $creatorID): self
    {
        $self = clone $this;
        $self['creatorID'] = $creatorID;

        return $self;
    }
}
