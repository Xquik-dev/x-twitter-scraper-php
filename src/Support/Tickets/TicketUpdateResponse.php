<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TicketUpdateResponseShape = array{
 *   publicID?: string|null, status?: string|null
 * }
 */
final class TicketUpdateResponse implements BaseModel
{
    /** @use SdkModel<TicketUpdateResponseShape> */
    use SdkModel;

    #[Optional('publicId')]
    public ?string $publicID;

    #[Optional]
    public ?string $status;

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
        ?string $publicID = null,
        ?string $status = null
    ): self {
        $self = new self;

        null !== $publicID && $self['publicID'] = $publicID;
        null !== $status && $self['status'] = $status;

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
}
