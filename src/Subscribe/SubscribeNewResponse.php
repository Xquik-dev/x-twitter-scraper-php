<?php

declare(strict_types=1);

namespace XTwitterScraper\Subscribe;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Subscribe\SubscribeNewResponse\Status;

/**
 * @phpstan-type SubscribeNewResponseShape = array{
 *   message: string, status: Status|value-of<Status>, url: string
 * }
 */
final class SubscribeNewResponse implements BaseModel
{
    /** @use SdkModel<SubscribeNewResponseShape> */
    use SdkModel;

    #[Required]
    public string $message;

    /** @var value-of<Status> $status */
    #[Required(enum: Status::class)]
    public string $status;

    #[Required]
    public string $url;

    /**
     * `new SubscribeNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SubscribeNewResponse::with(message: ..., status: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SubscribeNewResponse)->withMessage(...)->withStatus(...)->withURL(...)
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
    public static function with(
        string $message,
        Status|string $status,
        string $url
    ): self {
        $self = new self;

        $self['message'] = $message;
        $self['status'] = $status;
        $self['url'] = $url;

        return $self;
    }

    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

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

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
