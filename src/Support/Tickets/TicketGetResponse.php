<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Support\Tickets\TicketGetResponse\Message;

/**
 * @phpstan-import-type MessageShape from \XTwitterScraper\Support\Tickets\TicketGetResponse\Message
 *
 * @phpstan-type TicketGetResponseShape = array{
 *   createdAt?: \DateTimeInterface|null,
 *   messages?: list<Message|MessageShape>|null,
 *   publicID?: string|null,
 *   status?: string|null,
 *   subject?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class TicketGetResponse implements BaseModel
{
    /** @use SdkModel<TicketGetResponseShape> */
    use SdkModel;

    #[Optional]
    public ?\DateTimeInterface $createdAt;

    /** @var list<Message>|null $messages */
    #[Optional(list: Message::class)]
    public ?array $messages;

    #[Optional('publicId')]
    public ?string $publicID;

    #[Optional]
    public ?string $status;

    #[Optional]
    public ?string $subject;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Message|MessageShape>|null $messages
     */
    public static function with(
        ?\DateTimeInterface $createdAt = null,
        ?array $messages = null,
        ?string $publicID = null,
        ?string $status = null,
        ?string $subject = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $messages && $self['messages'] = $messages;
        null !== $publicID && $self['publicID'] = $publicID;
        null !== $status && $self['status'] = $status;
        null !== $subject && $self['subject'] = $subject;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * @param list<Message|MessageShape> $messages
     */
    public function withMessages(array $messages): self
    {
        $self = clone $this;
        $self['messages'] = $messages;

        return $self;
    }

    public function withPublicID(string $publicID): self
    {
        $self = clone $this;
        $self['publicID'] = $publicID;

        return $self;
    }

    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withSubject(string $subject): self
    {
        $self = clone $this;
        $self['subject'] = $subject;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
