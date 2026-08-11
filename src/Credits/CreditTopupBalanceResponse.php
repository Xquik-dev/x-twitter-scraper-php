<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Credits;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CreditTopupBalanceResponseShape = array{
 *   redirectURL: string, url: string
 * }
 */
final class CreditTopupBalanceResponse implements BaseModel
{
    /** @use SdkModel<CreditTopupBalanceResponseShape> */
    use SdkModel;

    /**
     * Stable Xquik redirect URL for the active checkout.
     */
    #[Required('redirect_url')]
    public string $redirectURL;

    /**
     * Same stable Xquik redirect URL as redirect_url. The response never exposes the hosted checkout URL.
     */
    #[Required]
    public string $url;

    /**
     * `new CreditTopupBalanceResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CreditTopupBalanceResponse::with(redirectURL: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CreditTopupBalanceResponse)->withRedirectURL(...)->withURL(...)
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
    public static function with(string $redirectURL, string $url): self
    {
        $self = new self;

        $self['redirectURL'] = $redirectURL;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Stable Xquik redirect URL for the active checkout.
     */
    public function withRedirectURL(string $redirectURL): self
    {
        $self = clone $this;
        $self['redirectURL'] = $redirectURL;

        return $self;
    }

    /**
     * Same stable Xquik redirect URL as redirect_url. The response never exposes the hosted checkout URL.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
