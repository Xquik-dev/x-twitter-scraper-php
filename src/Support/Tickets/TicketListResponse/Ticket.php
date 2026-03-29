<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets\TicketListResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TicketShape = array{
 *   createdAt?: \DateTimeInterface|null,
 *   messageCount?: int|null,
 *   publicID?: string|null,
 *   status?: string|null,
 *   subject?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class Ticket implements BaseModel
{
    /** @use SdkModel<TicketShape> */
    use SdkModel;

    #[Optional]
    public ?\DateTimeInterface $createdAt;

    #[Optional]
    public ?int $messageCount;

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
     */
    public static function with(
        ?\DateTimeInterface $createdAt = null,
        ?int $messageCount = null,
        ?string $publicID = null,
        ?string $status = null,
        ?string $subject = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $messageCount && $self['messageCount'] = $messageCount;
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
