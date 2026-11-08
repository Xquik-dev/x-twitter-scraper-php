<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks\Replies\Evidence;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\ShadowbanReport\Checks\Replies\Evidence\Replies\Placement;

/**
 * @phpstan-type RepliesShape = array{
 *   replyID: string,
 *   replyUrl: string,
 *   parentID: string,
 *   parentUrl: string,
 *   placement: Placement|value-of<Placement>,
 * }
 */
final class Replies implements BaseModel
{
    /** @use SdkModel<RepliesShape> */
    use SdkModel;

    /**
     * ID of the reply.
     */
    #[Required('replyId')]
    public string $replyID;

    /**
     * The reply on X.
     */
    #[Required]
    public string $replyUrl;

    /**
     * ID of the post it replies to.
     */
    #[Required('parentId')]
    public string $parentID;

    /**
     * The thread of that post on X.
     */
    #[Required]
    public string $parentUrl;

    /**
     * `thread` means the reply shows in the thread. `more_replies` means it shows only behind X's hidden replies prompt.
     *
     * @var value-of<Placement> $placement
     */
    #[Required(enum: Placement::class)]
    public string $placement;

    /**
     * `new Replies()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Replies::with(replyID: ..., replyUrl: ..., parentID: ..., parentUrl: ..., placement: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Replies)->withReplyID(...)->withReplyUrl(...)->withParentID(...)->withParentUrl(...)->withPlacement(...)
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
     *
     * @param Placement|value-of<Placement> $placement
     */
    public static function with(string $replyID, string $replyUrl, string $parentID, string $parentUrl, Placement|string $placement): self
    {
        $self = new self;

        $self['replyID'] = $replyID;
        $self['replyUrl'] = $replyUrl;
        $self['parentID'] = $parentID;
        $self['parentUrl'] = $parentUrl;
        $self['placement'] = $placement;

        return $self;
    }

    /**
     * ID of the reply.
     */
    public function withReplyID(string $replyID): self
    {
        $self = clone $this;
        $self['replyID'] = $replyID;

        return $self;
    }

    /**
     * The reply on X.
     */
    public function withReplyUrl(string $replyUrl): self
    {
        $self = clone $this;
        $self['replyUrl'] = $replyUrl;

        return $self;
    }

    /**
     * ID of the post it replies to.
     */
    public function withParentID(string $parentID): self
    {
        $self = clone $this;
        $self['parentID'] = $parentID;

        return $self;
    }

    /**
     * The thread of that post on X.
     */
    public function withParentUrl(string $parentUrl): self
    {
        $self = clone $this;
        $self['parentUrl'] = $parentUrl;

        return $self;
    }

    /**
     * `thread` means the reply shows in the thread. `more_replies` means it shows only behind X's hidden replies prompt.
     *
     * @param Placement|value-of<Placement> $placement
     */
    public function withPlacement(Placement|string $placement): self
    {
        $self = clone $this;
        $self['placement'] = $placement;

        return $self;
    }
}
