<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type NewsVersionShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   headline: string,
 *   text: string,
 * }
 */
final class NewsVersion implements BaseModel
{
    /** @use SdkModel<NewsVersionShape> */
    use SdkModel;

    /**
     * The version's ID.
     */
    #[Required]
    public string $id;

    /**
     * When X wrote the version, in UTC, from its ID.
     */
    #[Required]
    public \DateTimeInterface $createdAt;

    /**
     * The story's headline in this version.
     */
    #[Required]
    public string $headline;

    /**
     * The story's text in this version, without its time line.
     */
    #[Required]
    public string $text;

    /**
     * `new NewsVersion()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * NewsVersion::with(id: ..., createdAt: ..., headline: ..., text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new NewsVersion)->withId(...)->withCreatedAt(...)->withHeadline(...)->withText(...)
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
    public static function with(string $id, \DateTimeInterface $createdAt, string $headline, string $text): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['headline'] = $headline;
        $self['text'] = $text;

        return $self;
    }

    /**
     * The version's ID.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * When X wrote the version, in UTC, from its ID.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * The story's headline in this version.
     */
    public function withHeadline(string $headline): self
    {
        $self = clone $this;
        $self['headline'] = $headline;

        return $self;
    }

    /**
     * The story's text in this version, without its time line.
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }
}
