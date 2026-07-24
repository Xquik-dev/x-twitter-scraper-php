<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Communities\CommunityGetInfoResponse\Community;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CreatorShape = array{
 *   id: string, username: string, verified: bool, name?: string|null
 * }
 */
final class Creator implements BaseModel
{
    /** @use SdkModel<CreatorShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $username;

    #[Required]
    public bool $verified;

    #[Optional]
    public ?string $name;

    /**
     * `new Creator()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Creator::with(id: ..., username: ..., verified: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Creator)->withID(...)->withUsername(...)->withVerified(...)
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
    public static function with(
        string $id,
        string $username,
        bool $verified,
        ?string $name = null
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['username'] = $username;
        $self['verified'] = $verified;

        null !== $name && $self['name'] = $name;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withUsername(string $username): self
    {
        $self = clone $this;
        $self['username'] = $username;

        return $self;
    }

    public function withVerified(bool $verified): self
    {
        $self = clone $this;
        $self['verified'] = $verified;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
