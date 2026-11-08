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
 * Create a support ticket.
 *
 * @see XTwitterScraper\Services\Support\TicketsService::create()
 *
 * @phpstan-type TicketCreateParamsShape = array{
 *   body: string, subject: string, idempotencyKey?: string|null,
 *   attachments?: list<string>|null,
 * }
 */
final class TicketCreateParams implements BaseModel
{
    /** @use SdkModel<TicketCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $body;

    #[Required]
    public string $subject;

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
     * `new TicketCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TicketCreateParams::with(body: ..., subject: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TicketCreateParams)->withBody(...)->withSubject(...)
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
        string $subject,
        ?string $idempotencyKey = null,
        ?array $attachments = null
    ): self {
        $self = new self;

        $self['body'] = $body;
        $self['subject'] = $subject;

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

    public function withSubject(string $subject): self
    {
        $self = clone $this;
        $self['subject'] = $subject;

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
