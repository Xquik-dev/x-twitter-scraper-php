<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks\ReplyLock;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type EvidenceShape = array{
 *   checkedReplies: int,
 *   shownReplies: int,
 * }
 */
final class Evidence implements BaseModel
{
    /** @use SdkModel<EvidenceShape> */
    use SdkModel;

    /**
     * Replies it looked for, up to 3.
     */
    #[Required]
    public int $checkedReplies;

    /**
     * Replies that showed in their thread.
     */
    #[Required]
    public int $shownReplies;

    /**
     * `new Evidence()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Evidence::with(checkedReplies: ..., shownReplies: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Evidence)->withCheckedReplies(...)->withShownReplies(...)
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
    public static function with(int $checkedReplies, int $shownReplies): self
    {
        $self = new self;

        $self['checkedReplies'] = $checkedReplies;
        $self['shownReplies'] = $shownReplies;

        return $self;
    }

    /**
     * Replies it looked for, up to 3.
     */
    public function withCheckedReplies(int $checkedReplies): self
    {
        $self = clone $this;
        $self['checkedReplies'] = $checkedReplies;

        return $self;
    }

    /**
     * Replies that showed in their thread.
     */
    public function withShownReplies(int $shownReplies): self
    {
        $self = clone $this;
        $self['shownReplies'] = $shownReplies;

        return $self;
    }
}
