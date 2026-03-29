<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TicketNewResponseShape = array{publicID?: string|null}
 */
final class TicketNewResponse implements BaseModel
{
    /** @use SdkModel<TicketNewResponseShape> */
    use SdkModel;

    #[Optional('publicId')]
    public ?string $publicID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $publicID = null): self
    {
        $self = new self;

        null !== $publicID && $self['publicID'] = $publicID;

        return $self;
    }

    public function withPublicID(string $publicID): self
    {
        $self = clone $this;
        $self['publicID'] = $publicID;

        return $self;
    }
}
