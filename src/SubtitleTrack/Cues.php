<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\SubtitleTrack;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CuesShape = array{
 *   startMs: int,
 *   endMs: int,
 *   text: string,
 * }
 */
final class Cues implements BaseModel
{
    /** @use SdkModel<CuesShape> */
    use SdkModel;

    /**
     * Start time in milliseconds.
     */
    #[Required]
    public int $startMs;

    /**
     * End time in milliseconds.
     */
    #[Required]
    public int $endMs;

    /**
     * Caption text, with a line break between lines.
     */
    #[Required]
    public string $text;

    /**
     * `new Cues()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Cues::with(startMs: ..., endMs: ..., text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Cues)->withStartMs(...)->withEndMs(...)->withText(...)
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
    public static function with(int $startMs, int $endMs, string $text): self
    {
        $self = new self;

        $self['startMs'] = $startMs;
        $self['endMs'] = $endMs;
        $self['text'] = $text;

        return $self;
    }

    /**
     * Start time in milliseconds.
     */
    public function withStartMs(int $startMs): self
    {
        $self = clone $this;
        $self['startMs'] = $startMs;

        return $self;
    }

    /**
     * End time in milliseconds.
     */
    public function withEndMs(int $endMs): self
    {
        $self = clone $this;
        $self['endMs'] = $endMs;

        return $self;
    }

    /**
     * Caption text, with a line break between lines.
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }
}
