<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Dm\DmGetHistoryResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type MessageShape = array{
 *   id: string,
 *   receiverID: string,
 *   senderID: string,
 *   createdAt?: string|null,
 *   mediaURL?: string|null,
 *   text?: string|null,
 * }
 */
final class Message implements BaseModel
{
    /** @use SdkModel<MessageShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required('receiverId')]
    public string $receiverID;

    #[Required('senderId')]
    public string $senderID;

    #[Optional]
    public ?string $createdAt;

    /**
     * URL of attached media (image, GIF, or video). Omitted when the message has no media attachment.
     */
    #[Optional('mediaUrl')]
    public ?string $mediaURL;

    #[Optional]
    public ?string $text;

    /**
     * `new Message()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Message::with(id: ..., receiverID: ..., senderID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Message)->withID(...)->withReceiverID(...)->withSenderID(...)
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
    public static function with(
        string $id,
        string $receiverID,
        string $senderID,
        ?string $createdAt = null,
        ?string $mediaURL = null,
        ?string $text = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['receiverID'] = $receiverID;
        $self['senderID'] = $senderID;

        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $mediaURL && $self['mediaURL'] = $mediaURL;
        null !== $text && $self['text'] = $text;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withReceiverID(string $receiverID): self
    {
        $self = clone $this;
        $self['receiverID'] = $receiverID;

        return $self;
    }

    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }

    public function withCreatedAt(string $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * URL of attached media (image, GIF, or video). Omitted when the message has no media attachment.
     */
    public function withMediaURL(string $mediaURL): self
    {
        $self = clone $this;
        $self['mediaURL'] = $mediaURL;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }
}
