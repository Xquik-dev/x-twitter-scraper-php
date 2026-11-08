<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\UnanalyzedTweet\Status;

/**
 * @phpstan-type UnanalyzedTweetShape = array{
 *   id: string,
 *   status: Status|value-of<Status>,
 *   reason: string,
 * }
 */
final class UnanalyzedTweet implements BaseModel
{
    /** @use SdkModel<UnanalyzedTweetShape> */
    use SdkModel;

    /**
     * Post ID. Your own texts have the IDs text:1, text:2 & so on.
     */
    #[Required]
    public string $id;

    /**
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * post_unavailable when X returns no such post. missing_text for a post without text. insufficient_credits when credits ran out. context_limit when the settings leave the post no room. The other reasons mean the analysis failed. Send the post again.
     */
    #[Required]
    public string $reason;

    /**
     * `new UnanalyzedTweet()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UnanalyzedTweet::with(id: ..., status: ..., reason: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UnanalyzedTweet)->withId(...)->withStatus(...)->withReason(...)
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
     * @param Status|value-of<Status> $status
     */
    public static function with(string $id, Status|string $status, string $reason): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['status'] = $status;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * Post ID. Your own texts have the IDs text:1, text:2 & so on.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * post_unavailable when X returns no such post. missing_text for a post without text. insufficient_credits when credits ran out. context_limit when the settings leave the post no room. The other reasons mean the analysis failed. Send the post again.
     */
    public function withReason(string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }
}
