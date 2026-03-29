<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Support\Tickets\TicketListResponse\Ticket;

/**
 * @phpstan-import-type TicketShape from \XTwitterScraper\Support\Tickets\TicketListResponse\Ticket
 *
 * @phpstan-type TicketListResponseShape = array{
 *   tickets?: list<Ticket|TicketShape>|null
 * }
 */
final class TicketListResponse implements BaseModel
{
    /** @use SdkModel<TicketListResponseShape> */
    use SdkModel;

    /** @var list<Ticket>|null $tickets */
    #[Optional(list: Ticket::class)]
    public ?array $tickets;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Ticket|TicketShape>|null $tickets
     */
    public static function with(?array $tickets = null): self
    {
        $self = new self;

        null !== $tickets && $self['tickets'] = $tickets;

        return $self;
    }

    /**
     * @param list<Ticket|TicketShape> $tickets
     */
    public function withTickets(array $tickets): self
    {
        $self = clone $this;
        $self['tickets'] = $tickets;

        return $self;
    }
}
