<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Support\Tickets\TicketUpdateResponse\Status;

/**
 * @phpstan-type TicketUpdateResponseShape = array{
 *   publicID: string, status: Status|value-of<Status>
 * }
 */
final class TicketUpdateResponse implements BaseModel
{
    /** @use SdkModel<TicketUpdateResponseShape> */
    use SdkModel;

    #[Required('publicId')]
    public string $publicID;

    /** @var value-of<Status> $status */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * `new TicketUpdateResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TicketUpdateResponse::with(publicID: ..., status: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TicketUpdateResponse)->withPublicID(...)->withStatus(...)
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
    public static function with(string $publicID, Status|string $status): self
    {
        $self = new self;

        $self['publicID'] = $publicID;
        $self['status'] = $status;

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
}
