<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\GuestWallets\GuestWalletTopupResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\GuestWallets\GuestWalletTopupResponse\Authorization\Header;
use XTwitterScraper\GuestWallets\GuestWalletTopupResponse\Authorization\Scheme;

/**
 * @phpstan-type AuthorizationShape = array{
 *   header: Header|value-of<Header>, scheme: Scheme|value-of<Scheme>
 * }
 */
final class Authorization implements BaseModel
{
    /** @use SdkModel<AuthorizationShape> */
    use SdkModel;

    /** @var value-of<Header> $header */
    #[Required(enum: Header::class)]
    public string $header;

    /** @var value-of<Scheme> $scheme */
    #[Required(enum: Scheme::class)]
    public string $scheme;

    /**
     * `new Authorization()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Authorization::with(header: ..., scheme: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Authorization)->withHeader(...)->withScheme(...)
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
     * @param Header|value-of<Header> $header
     * @param Scheme|value-of<Scheme> $scheme
     */
    public static function with(
        Header|string $header,
        Scheme|string $scheme
    ): self {
        $self = new self;

        $self['header'] = $header;
        $self['scheme'] = $scheme;

        return $self;
    }

    /**
     * @param Header|value-of<Header> $header
     */
    public function withHeader(Header|string $header): self
    {
        $self = clone $this;
        $self['header'] = $header;

        return $self;
    }

    /**
     * @param Scheme|value-of<Scheme> $scheme
     */
    public function withScheme(Scheme|string $scheme): self
    {
        $self = clone $this;
        $self['scheme'] = $scheme;

        return $self;
    }
}
