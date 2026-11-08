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
 * @phpstan-type TweetExclusiveContentShape = array{
 *   creatorUserName: string,
 *   subscribeUrl?: string|null,
 * }
 */
final class TweetExclusiveContent implements BaseModel
{
    /** @use SdkModel<TweetExclusiveContentShape> */
    use SdkModel;

    /**
     * Username of the creator whose subscription unlocks the post.
     */
    #[Required]
    public string $creatorUserName;

    /**
     * Subscribe link X shows non-subscribers. Omitted when X serves the full post.
     */
    #[Optional]
    public ?string $subscribeUrl;

    /**
     * `new TweetExclusiveContent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetExclusiveContent::with(creatorUserName: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetExclusiveContent)->withCreatorUserName(...)
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
    public static function with(string $creatorUserName, ?string $subscribeUrl = null): self
    {
        $self = new self;

        $self['creatorUserName'] = $creatorUserName;

        null !== $subscribeUrl && $self['subscribeUrl'] = $subscribeUrl;

        return $self;
    }

    /**
     * Username of the creator whose subscription unlocks the post.
     */
    public function withCreatorUserName(string $creatorUserName): self
    {
        $self = clone $this;
        $self['creatorUserName'] = $creatorUserName;

        return $self;
    }

    /**
     * Subscribe link X shows non-subscribers. Omitted when X serves the full post.
     */
    public function withSubscribeUrl(?string $subscribeUrl): self
    {
        $self = clone $this;
        $self['subscribeUrl'] = $subscribeUrl;

        return $self;
    }
}
