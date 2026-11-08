<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\PaginatedTweets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type SkippedShape = array{
 *   entry: string,
 *   reason: string,
 * }
 */
final class Skipped implements BaseModel
{
    /** @use SdkModel<SkippedShape> */
    use SdkModel;

    /**
     * The entry as sent.
     */
    #[Required]
    public string $entry;

    /**
     * Why the entry names no post.
     */
    #[Required]
    public string $reason;

    /**
     * `new Skipped()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Skipped::with(entry: ..., reason: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Skipped)->withEntry(...)->withReason(...)
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
    public static function with(string $entry, string $reason): self
    {
        $self = new self;

        $self['entry'] = $entry;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * The entry as sent.
     */
    public function withEntry(string $entry): self
    {
        $self = clone $this;
        $self['entry'] = $entry;

        return $self;
    }

    /**
     * Why the entry names no post.
     */
    public function withReason(string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }
}
