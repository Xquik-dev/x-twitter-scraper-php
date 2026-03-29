<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Reply to a support ticket.
 *
 * @see XTwitterScraper\Services\Support\TicketsService::reply()
 *
 * @phpstan-type TicketReplyParamsShape = array{body: string}
 */
final class TicketReplyParams implements BaseModel
{
    /** @use SdkModel<TicketReplyParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $body;

    /**
     * `new TicketReplyParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TicketReplyParams::with(body: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TicketReplyParams)->withBody(...)
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
     */
    public static function with(string $body): self
    {
        $self = new self;

        $self['body'] = $body;

        return $self;
    }

    public function withBody(string $body): self
    {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }
}
