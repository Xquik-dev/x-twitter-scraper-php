<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Webhooks;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\EventType;

/**
 * Returns a t.me link to @XquikBot that connects a Telegram chat to the account's monitor events. Opening it & pressing Start connects the chat, which then gets each alert as a message. Alerts that wait together come as 1 digest. A busy chat gets 5 quick messages, then 1 every 30 s. Only 1 message a minute rings. The link works once, within 15 minutes. The chat appears in the webhook list with the URL `telegram:<chat ID>`, with deliveries, retries & resume as any webhook. In the chat, /stop pauses its alerts. It costs no credits.
 *
 * @see XTwitterScraper\Services\WebhooksService::createTelegramLink()
 *
 * @phpstan-type WebhookCreateTelegramLinkParamsShape = array{
 *   eventTypes?: list<EventType|value-of<EventType>>|null,
 * }
 */
final class WebhookCreateTelegramLinkParams implements BaseModel
{
    /** @use SdkModel<WebhookCreateTelegramLinkParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Array of event types to subscribe to.
     *
     * @var list<value-of<EventType>>|null $eventTypes
     */
    #[Optional(list: EventType::class)]
    public ?array $eventTypes;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<EventType|value-of<EventType>>|null $eventTypes
     */
    public static function with(?array $eventTypes = null): self
    {
        $self = new self;

        null !== $eventTypes && $self['eventTypes'] = $eventTypes;

        return $self;
    }

    /**
     * Array of event types to subscribe to.
     *
     * @param list<EventType|value-of<EventType>>|null $eventTypes
     */
    public function withEventTypes(?array $eventTypes): self
    {
        $self = clone $this;
        $self['eventTypes'] = $eventTypes;

        return $self;
    }
}
