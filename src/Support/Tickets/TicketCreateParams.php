<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Create a support ticket.
 *
 * @see XTwitterScraper\Services\Support\TicketsService::create()
 *
 * @phpstan-type TicketCreateParamsShape = array{body: string, subject: string}
 */
final class TicketCreateParams implements BaseModel
{
    /** @use SdkModel<TicketCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $body;

    #[Required]
    public string $subject;

    /**
     * `new TicketCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TicketCreateParams::with(body: ..., subject: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TicketCreateParams)->withBody(...)->withSubject(...)
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
    public static function with(string $body, string $subject): self
    {
        $self = new self;

        $self['body'] = $body;
        $self['subject'] = $subject;

        return $self;
    }

    public function withBody(string $body): self
    {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }

    public function withSubject(string $subject): self
    {
        $self = clone $this;
        $self['subject'] = $subject;

        return $self;
    }
}
