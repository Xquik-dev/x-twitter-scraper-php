<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Webhooks;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type WebhookCreateTelegramLinkResponseShape = array{
 *   url: string,
 *   expiresAt: \DateTimeInterface,
 * }
 */
final class WebhookCreateTelegramLinkResponse implements BaseModel
{
    /** @use SdkModel<WebhookCreateTelegramLinkResponseShape> */
    use SdkModel;

    /**
     * Opens @XquikBot with the link's code.
     */
    #[Required]
    public string $url;

    /**
     * When the link stops working, 15 minutes after creation.
     */
    #[Required]
    public \DateTimeInterface $expiresAt;

    /**
     * `new WebhookCreateTelegramLinkResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebhookCreateTelegramLinkResponse::with(url: ..., expiresAt: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebhookCreateTelegramLinkResponse)->withUrl(...)->withExpiresAt(...)
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
    public static function with(string $url, \DateTimeInterface $expiresAt): self
    {
        $self = new self;

        $self['url'] = $url;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }

    /**
     * Opens @XquikBot with the link's code.
     */
    public function withUrl(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * When the link stops working, 15 minutes after creation.
     */
    public function withExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }
}
