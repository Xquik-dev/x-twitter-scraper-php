<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets\TicketGetResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Support\Tickets\TicketGetResponse\Message\Attachment;

/**
 * @phpstan-import-type AttachmentShape from \XTwitterScraper\Support\Tickets\TicketGetResponse\Message\Attachment
 *
 * @phpstan-type MessageShape = array{
 *   attachments?: list<Attachment|AttachmentShape>|null,
 *   body?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   sender?: string|null,
 * }
 */
final class Message implements BaseModel
{
    /** @use SdkModel<MessageShape> */
    use SdkModel;

    /** @var list<Attachment>|null $attachments */
    #[Optional(list: Attachment::class)]
    public ?array $attachments;

    #[Optional]
    public ?string $body;

    #[Optional]
    public ?\DateTimeInterface $createdAt;

    #[Optional]
    public ?string $sender;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Attachment|AttachmentShape>|null $attachments
     */
    public static function with(
        ?array $attachments = null,
        ?string $body = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $sender = null,
    ): self {
        $self = new self;

        null !== $attachments && $self['attachments'] = $attachments;
        null !== $body && $self['body'] = $body;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $sender && $self['sender'] = $sender;

        return $self;
    }

    /**
     * @param list<Attachment|AttachmentShape> $attachments
     */
    public function withAttachments(array $attachments): self
    {
        $self = clone $this;
        $self['attachments'] = $attachments;

        return $self;
    }

    public function withBody(string $body): self
    {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withSender(string $sender): self
    {
        $self = clone $this;
        $self['sender'] = $sender;

        return $self;
    }
}
