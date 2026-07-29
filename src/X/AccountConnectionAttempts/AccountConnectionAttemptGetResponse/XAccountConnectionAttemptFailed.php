<?php

declare(strict_types=1);

namespace XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * The connection reached a final failure.
 *
 * @phpstan-type XAccountConnectionAttemptFailedShape = array{
 *   id: string,
 *   error: string,
 *   object: 'x_account_connection_attempt',
 *   retryable: bool,
 *   status: 'failed',
 *   reason?: string|null,
 * }
 */
final class XAccountConnectionAttemptFailed implements BaseModel
{
    /** @use SdkModel<XAccountConnectionAttemptFailedShape> */
    use SdkModel;

    /** @var 'x_account_connection_attempt' $object */
    #[Required]
    public string $object = 'x_account_connection_attempt';

    /** @var 'failed' $status */
    #[Required]
    public string $status = 'failed';

    #[Required]
    public string $id;

    #[Required]
    public string $error;

    #[Required]
    public bool $retryable;

    #[Optional]
    public ?string $reason;

    /**
     * `new XAccountConnectionAttemptFailed()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XAccountConnectionAttemptFailed::with(id: ..., error: ..., retryable: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XAccountConnectionAttemptFailed)
     *   ->withID(...)
     *   ->withError(...)
     *   ->withRetryable(...)
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
    public static function with(
        string $id,
        string $error,
        bool $retryable,
        ?string $reason = null
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['error'] = $error;
        $self['retryable'] = $retryable;

        null !== $reason && $self['reason'] = $reason;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withError(string $error): self
    {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * @param 'x_account_connection_attempt' $object
     */
    public function withObject(string $object): self
    {
        $self = clone $this;
        $self['object'] = $object;

        return $self;
    }

    public function withRetryable(bool $retryable): self
    {
        $self = clone $this;
        $self['retryable'] = $retryable;

        return $self;
    }

    /**
     * @param 'failed' $status
     */
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withReason(string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }
}
