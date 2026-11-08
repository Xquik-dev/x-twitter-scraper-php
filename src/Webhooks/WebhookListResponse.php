<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Webhooks;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type WebhookShape from Webhook
 *
 * @phpstan-type WebhookListResponseShape = array{
 *   webhooks: list<Webhook|WebhookShape>,
 *   hasMore?: bool|null,
 *   nextCursor?: string|null,
 * }
 */
final class WebhookListResponse implements BaseModel
{
    /** @use SdkModel<WebhookListResponseShape> */
    use SdkModel;

    /** @var list<Webhook> $webhooks */
    #[Required(list: Webhook::class)]
    public array $webhooks;

    #[Optional]
    public ?bool $hasMore;

    #[Optional]
    public ?string $nextCursor;

    /**
     * `new WebhookListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebhookListResponse::with(webhooks: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebhookListResponse)->withWebhooks(...)
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
     * @param list<Webhook|WebhookShape> $webhooks
     */
    public static function with(array $webhooks, ?bool $hasMore = null, ?string $nextCursor = null): self
    {
        $self = new self;

        $self['webhooks'] = $webhooks;

        null !== $hasMore && $self['hasMore'] = $hasMore;

        null !== $nextCursor && $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * @param list<Webhook|WebhookShape> $webhooks
     */
    public function withWebhooks(array $webhooks): self
    {
        $self = clone $this;
        $self['webhooks'] = $webhooks;

        return $self;
    }

    public function withHasMore(?bool $hasMore): self
    {
        $self = clone $this;
        $self['hasMore'] = $hasMore;

        return $self;
    }

    public function withNextCursor(?string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }
}
