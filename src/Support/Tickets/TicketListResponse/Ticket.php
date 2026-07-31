<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets\TicketListResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Support\Tickets\TicketListResponse\Ticket\Status;

/**
 * @phpstan-type TicketShape = array{
 *   createdAt: \DateTimeInterface,
 *   messageCount: int,
 *   publicID: string,
 *   status: Status|value-of<Status>,
 *   subject: string,
 *   updatedAt: \DateTimeInterface,
 * }
 */
final class Ticket implements BaseModel
{
    /** @use SdkModel<TicketShape> */
    use SdkModel;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public int $messageCount;

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
     * `new Ticket()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Ticket::with(
     *   createdAt: ...,
     *   messageCount: ...,
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
     * (new Ticket)
     *   ->withCreatedAt(...)
     *   ->withMessageCount(...)
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
     * @param Status|value-of<Status> $status
     */
    public static function with(
        \DateTimeInterface $createdAt,
        int $messageCount,
        string $publicID,
        Status|string $status,
        string $subject,
        \DateTimeInterface $updatedAt,
    ): self {
        $self = new self;

        $self['createdAt'] = $createdAt;
        $self['messageCount'] = $messageCount;
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

    public function withMessageCount(int $messageCount): self
    {
        $self = clone $this;
        $self['messageCount'] = $messageCount;

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
