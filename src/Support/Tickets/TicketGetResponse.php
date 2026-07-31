<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Support\Tickets\TicketGetResponse\Message;
use XTwitterScraper\Support\Tickets\TicketGetResponse\Status;

/**
 * @phpstan-import-type MessageShape from \XTwitterScraper\Support\Tickets\TicketGetResponse\Message
 *
 * @phpstan-type TicketGetResponseShape = array{
 *   createdAt: \DateTimeInterface,
 *   messages: list<Message|MessageShape>,
 *   publicID: string,
 *   status: Status|value-of<Status>,
 *   subject: string,
 *   updatedAt: \DateTimeInterface,
 * }
 */
final class TicketGetResponse implements BaseModel
{
    /** @use SdkModel<TicketGetResponseShape> */
    use SdkModel;

    #[Required]
    public \DateTimeInterface $createdAt;

    /** @var list<Message> $messages */
    #[Required(list: Message::class)]
    public array $messages;

    #[Required('publicId')]
    public string $publicID;

    /** @var value-of<Status> $status */
    #[Required(enum: Status::class)]
    public string $status;

    #[Required]
    public string $subject;

    #[Required]
    public \DateTimeInterface $updatedAt;

    /**
     * `new TicketGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TicketGetResponse::with(
     *   createdAt: ...,
     *   messages: ...,
     *   publicID: ...,
     *   status: ...,
     *   subject: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TicketGetResponse)
     *   ->withCreatedAt(...)
     *   ->withMessages(...)
     *   ->withPublicID(...)
     *   ->withStatus(...)
     *   ->withSubject(...)
     *   ->withUpdatedAt(...)
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
     * @param list<Message|MessageShape> $messages
     * @param Status|value-of<Status> $status
     */
    public static function with(
        \DateTimeInterface $createdAt,
        array $messages,
        string $publicID,
        Status|string $status,
        string $subject,
        \DateTimeInterface $updatedAt,
    ): self {
        $self = new self;

        $self['createdAt'] = $createdAt;
        $self['messages'] = $messages;
        $self['publicID'] = $publicID;
        $self['status'] = $status;
        $self['subject'] = $subject;
        $self['updatedAt'] = $updatedAt;

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

    /**
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
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
