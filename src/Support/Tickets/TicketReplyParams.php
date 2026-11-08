<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Reply to a support ticket.
 *
 * @see XTwitterScraper\Services\Support\TicketsService::reply()
 *
 * @phpstan-type TicketReplyParamsShape = array{
 *   body: string, idempotencyKey?: string|null,
 *   attachments?: list<string>|null,
 * }
 */
final class TicketReplyParams implements BaseModel
{
    /** @use SdkModel<TicketReplyParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $body;

    #[Optional]
    public ?string $idempotencyKey;

    /**
     * 1 to 4 support image or video uploads.
     *
     * @var list<string>|null $attachments
     */
    #[Optional(list: 'string')]
    public ?array $attachments;

    /**
     * `new TicketReplyParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TicketReplyParams::with(body: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TicketReplyParams)->withBody(...)
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
     * @param list<string>|null $attachments
     */
    public static function with(
        string $body,
        ?string $idempotencyKey = null,
        ?array $attachments = null
    ): self {
        $self = new self;

        $self['body'] = $body;

        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;

        null !== $attachments && $self['attachments'] = $attachments;

        return $self;
    }

    public function withBody(string $body): self
    {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    /**
     * 1 to 4 support image or video uploads.
     *
     * @param list<string>|null $attachments
     */
    public function withAttachments(?array $attachments): self
    {
        $self = clone $this;
        $self['attachments'] = $attachments;

        return $self;
    }
}
