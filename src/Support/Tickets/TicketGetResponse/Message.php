<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets\TicketGetResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Support\Tickets\TicketGetResponse\Message\Attachment;
use XTwitterScraper\Support\Tickets\TicketGetResponse\Message\Sender;

/**
 * @phpstan-import-type AttachmentShape from \XTwitterScraper\Support\Tickets\TicketGetResponse\Message\Attachment
 *
 * @phpstan-type MessageShape = array{
 *   attachments: list<Attachment|AttachmentShape>,
 *   body: string,
 *   createdAt: \DateTimeInterface,
 *   sender: Sender|value-of<Sender>,
 * }
 */
final class Message implements BaseModel
{
    /** @use SdkModel<MessageShape> */
    use SdkModel;

    /** @var list<Attachment> $attachments */
    #[Required(list: Attachment::class)]
    public array $attachments;

    #[Required]
    public string $body;

    #[Required]
    public \DateTimeInterface $createdAt;

    /** @var value-of<Sender> $sender */
    #[Required(enum: Sender::class)]
    public string $sender;

    /**
     * `new Message()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Message::with(attachments: ..., body: ..., createdAt: ..., sender: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Message)
     *   ->withAttachments(...)
     *   ->withBody(...)
     *   ->withCreatedAt(...)
     *   ->withSender(...)
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
     * @param list<Attachment|AttachmentShape> $attachments
     * @param Sender|value-of<Sender> $sender
     */
    public static function with(
        array $attachments,
        string $body,
        \DateTimeInterface $createdAt,
        Sender|string $sender,
    ): self {
        $self = new self;

        $self['attachments'] = $attachments;
        $self['body'] = $body;
        $self['createdAt'] = $createdAt;
        $self['sender'] = $sender;

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

    /**
     * @param Sender|value-of<Sender> $sender
     */
    public function withSender(Sender|string $sender): self
    {
        $self = clone $this;
        $self['sender'] = $sender;

        return $self;
    }
}
