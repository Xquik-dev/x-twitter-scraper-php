<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\NewsVersion;

/**
 * @phpstan-type XGetNewsStoryVersionsResponseShape = array{
 *   id: string,
 *   count: int,
 *   versions: list<NewsVersion|array<string,mixed>>,
 * }
 */
final class XGetNewsStoryVersionsResponse implements BaseModel
{
    /** @use SdkModel<XGetNewsStoryVersionsResponseShape> */
    use SdkModel;

    /**
     * The story's ID, as the request named it.
     */
    #[Required]
    public string $id;

    /**
     * Versions returned.
     */
    #[Required]
    public int $count;

    /**
     * @var list<NewsVersion> $versions
     */
    #[Required(list: NewsVersion::class)]
    public array $versions;

    /**
     * `new XGetNewsStoryVersionsResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XGetNewsStoryVersionsResponse::with(id: ..., count: ..., versions: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XGetNewsStoryVersionsResponse)->withId(...)->withCount(...)->withVersions(...)
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
     * @param list<NewsVersion|array<string,mixed>> $versions
     */
    public static function with(string $id, int $count, array $versions): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['count'] = $count;
        $self['versions'] = $versions;

        return $self;
    }

    /**
     * The story's ID, as the request named it.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Versions returned.
     */
    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    /**
     * @param list<NewsVersion|array<string,mixed>> $versions
     */
    public function withVersions(array $versions): self
    {
        $self = clone $this;
        $self['versions'] = $versions;

        return $self;
    }
}
