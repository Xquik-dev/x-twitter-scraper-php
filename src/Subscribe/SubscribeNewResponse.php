<?php

declare(strict_types=1);

namespace XTwitterScraper\Subscribe;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Subscribe\SubscribeNewResponse\Status;

/**
 * @phpstan-type SubscribeNewResponseShape = array{
 *   url: string, message?: string|null, status?: null|Status|value-of<Status>
 * }
 */
final class SubscribeNewResponse implements BaseModel
{
    /** @use SdkModel<SubscribeNewResponseShape> */
    use SdkModel;

    #[Required]
    public string $url;

    #[Optional]
    public ?string $message;

    /** @var value-of<Status>|null $status */
    #[Optional(enum: Status::class)]
    public ?string $status;

    /**
     * `new SubscribeNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SubscribeNewResponse::with(url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SubscribeNewResponse)->withURL(...)
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
     * @param Status|value-of<Status>|null $status
     */
    public static function with(
        string $url,
        ?string $message = null,
        Status|string|null $status = null
    ): self {
        $self = new self;

        $self['url'] = $url;

        null !== $message && $self['message'] = $message;
        null !== $status && $self['status'] = $status;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
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
}
