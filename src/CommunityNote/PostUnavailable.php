<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\CommunityNote;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type PostUnavailableShape = array{
 *   reason: string,
 * }
 */
final class PostUnavailable implements BaseModel
{
    /** @use SdkModel<PostUnavailableShape> */
    use SdkModel;

    /**
     * Why X shows no post, as X names it.
     */
    #[Required]
    public string $reason;

    /**
     * `new PostUnavailable()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PostUnavailable::with(reason: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PostUnavailable)->withReason(...)
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
     * Why X shows no post, as X names it.
     */
    public function withReason(string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }
}
