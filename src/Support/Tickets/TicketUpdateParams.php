<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Support\Tickets\TicketUpdateParams\Status;

/**
 * Update ticket status.
 *
 * @see XTwitterScraper\Services\Support\TicketsService::update()
 *
 * @phpstan-type TicketUpdateParamsShape = array{status: Status|value-of<Status>}
 */
final class TicketUpdateParams implements BaseModel
{
    /** @use SdkModel<TicketUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /** @var value-of<Status> $status */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * `new TicketUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TicketUpdateParams::with(status: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TicketUpdateParams)->withStatus(...)
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
    public static function with(Status|string $status): self
    {
        $self = new self;

        $self['status'] = $status;

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
}
