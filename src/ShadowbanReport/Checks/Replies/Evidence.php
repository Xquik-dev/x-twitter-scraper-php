<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks\Replies;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\ShadowbanReport\Checks\Replies\Evidence\Replies;

/**
 * @phpstan-type EvidenceShape = array{
 *   replies: list<Replies|array<string,mixed>>,
 * }
 */
final class Evidence implements BaseModel
{
    /** @use SdkModel<EvidenceShape> */
    use SdkModel;

    /**
     * Up to 3 replies, newest first.
     *
     * @var list<Replies> $replies
     */
    #[Required(list: Replies::class)]
    public array $replies;

    /**
     * `new Evidence()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Evidence::with(replies: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Evidence)->withReplies(...)
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
     * @param list<Replies|array<string,mixed>> $replies
     */
    public static function with(array $replies): self
    {
        $self = new self;

        $self['replies'] = $replies;

        return $self;
    }

    /**
     * Up to 3 replies, newest first.
     *
     * @param list<Replies|array<string,mixed>> $replies
     */
    public function withReplies(array $replies): self
    {
        $self = clone $this;
        $self['replies'] = $replies;

        return $self;
    }
}
