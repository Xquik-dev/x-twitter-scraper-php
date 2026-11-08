<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetAnalysisResult\Analysis;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type QuestionsShape = array{
 *   id: string,
 *   version: string,
 * }
 */
final class Questions implements BaseModel
{
    /** @use SdkModel<QuestionsShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $version;

    /**
     * `new Questions()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Questions::with(id: ..., version: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Questions)->withId(...)->withVersion(...)
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
    public static function with(string $id, string $version): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['version'] = $version;

        return $self;
    }

    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withVersion(string $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

        return $self;
    }
}
