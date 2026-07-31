<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Support\Tickets\TicketListResponse\Ticket;

/**
 * @phpstan-import-type TicketShape from \XTwitterScraper\Support\Tickets\TicketListResponse\Ticket
 *
 * @phpstan-type TicketListResponseShape = array{tickets: list<Ticket|TicketShape>}
 */
final class TicketListResponse implements BaseModel
{
    /** @use SdkModel<TicketListResponseShape> */
    use SdkModel;

    /** @var list<Ticket> $tickets */
    #[Required(list: Ticket::class)]
    public array $tickets;

    /**
     * `new TicketListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TicketListResponse::with(tickets: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TicketListResponse)->withTickets(...)
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
     * @param list<Ticket|TicketShape> $tickets
     */
    public static function with(array $tickets): self
    {
        $self = new self;

        $self['tickets'] = $tickets;

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
