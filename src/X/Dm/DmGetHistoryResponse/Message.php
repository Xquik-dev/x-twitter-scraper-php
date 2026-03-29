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
 *   createdAt?: string|null,
 *   receiverID?: string|null,
 *   senderID?: string|null,
 *   text?: string|null,
 * }
 */
final class Message implements BaseModel
{
    /** @use SdkModel<MessageShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Optional]
    public ?string $createdAt;

    #[Optional('receiverId')]
    public ?string $receiverID;

    #[Optional('senderId')]
    public ?string $senderID;

    #[Optional]
    public ?string $text;

    /**
     * `new Message()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Message::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Message)->withID(...)
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
        ?string $createdAt = null,
        ?string $receiverID = null,
        ?string $senderID = null,
        ?string $text = null,
    ): self {
        $self = new self;

        $self['id'] = $id;

        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $receiverID && $self['receiverID'] = $receiverID;
        null !== $senderID && $self['senderID'] = $senderID;
        null !== $text && $self['text'] = $text;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCreatedAt(string $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

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

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }
}
