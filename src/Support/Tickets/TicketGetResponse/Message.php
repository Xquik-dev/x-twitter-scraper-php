<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets\TicketGetResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type MessageShape = array{
 *   body?: string|null, createdAt?: \DateTimeInterface|null, sender?: string|null
 * }
 */
final class Message implements BaseModel
{
    /** @use SdkModel<MessageShape> */
    use SdkModel;

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
     */
    public static function with(
        ?string $body = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $sender = null,
    ): self {
        $self = new self;

        null !== $body && $self['body'] = $body;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $sender && $self['sender'] = $sender;

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
