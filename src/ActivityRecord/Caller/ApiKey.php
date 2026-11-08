<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ActivityRecord\Caller;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ApiKeyShape = array{
 *   name: string,
 *   prefix: string,
 * }
 */
final class ApiKey implements BaseModel
{
    /** @use SdkModel<ApiKeyShape> */
    use SdkModel;

    #[Required]
    public string $name;

    #[Required]
    public string $prefix;

    /**
     * `new ApiKey()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ApiKey::with(name: ..., prefix: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ApiKey)->withName(...)->withPrefix(...)
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
    public static function with(string $name, string $prefix): self
    {
        $self = new self;

        $self['name'] = $name;
        $self['prefix'] = $prefix;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withPrefix(string $prefix): self
    {
        $self = clone $this;
        $self['prefix'] = $prefix;

        return $self;
    }
}
