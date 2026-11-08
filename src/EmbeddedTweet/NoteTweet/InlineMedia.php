<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\EmbeddedTweet\NoteTweet;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type InlineMediaShape = array{
 *   index: int,
 *   mediaID: string,
 * }
 */
final class InlineMedia implements BaseModel
{
    /** @use SdkModel<InlineMediaShape> */
    use SdkModel;

    /**
     * Whole number from 0.
     */
    #[Required]
    public int $index;

    #[Required('mediaId')]
    public string $mediaID;

    /**
     * `new InlineMedia()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * InlineMedia::with(index: ..., mediaID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new InlineMedia)->withIndex(...)->withMediaID(...)
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
    public static function with(int $index, string $mediaID): self
    {
        $self = new self;

        $self['index'] = $index;
        $self['mediaID'] = $mediaID;

        return $self;
    }

    /**
     * Whole number from 0.
     */
    public function withIndex(int $index): self
    {
        $self = clone $this;
        $self['index'] = $index;

        return $self;
    }

    public function withMediaID(string $mediaID): self
    {
        $self = clone $this;
        $self['mediaID'] = $mediaID;

        return $self;
    }
}
