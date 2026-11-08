<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\FootballPlay;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type PostShape = array{
 *   id: string,
 *   username: string|null,
 * }
 */
final class Post implements BaseModel
{
    /** @use SdkModel<PostShape> */
    use SdkModel;

    /**
     * The post's ID.
     */
    #[Required]
    public string $id;

    /**
     * The username of the post's author, when X sends it.
     */
    #[Required]
    public ?string $username;

    /**
     * `new Post()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Post::with(id: ..., username: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Post)->withId(...)->withUsername(...)
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
    public static function with(string $id, ?string $username): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['username'] = $username;

        return $self;
    }

    /**
     * The post's ID.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The username of the post's author, when X sends it.
     */
    public function withUsername(?string $username): self
    {
        $self = clone $this;
        $self['username'] = $username;

        return $self;
    }
}
