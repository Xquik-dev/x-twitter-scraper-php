<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Accounts\AccountNewResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * The connection is still in progress.
 *
 * @phpstan-type XAccountConnectionAttemptPendingShape = array{
 *   id: string,
 *   object: 'x_account_connection_attempt',
 *   pollAfterMs: int,
 *   status: 'pending',
 * }
 */
final class XAccountConnectionAttemptPending implements BaseModel
{
    /** @use SdkModel<XAccountConnectionAttemptPendingShape> */
    use SdkModel;

    /** @var 'x_account_connection_attempt' $object */
    #[Required]
    public string $object = 'x_account_connection_attempt';

    /** @var 'pending' $status */
    #[Required]
    public string $status = 'pending';

    #[Required]
    public string $id;

    #[Required]
    public int $pollAfterMs;

    /**
     * `new XAccountConnectionAttemptPending()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XAccountConnectionAttemptPending::with(id: ..., pollAfterMs: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XAccountConnectionAttemptPending)->withID(...)->withPollAfterMs(...)
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
    public static function with(string $id, int $pollAfterMs): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['pollAfterMs'] = $pollAfterMs;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

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

    public function withPollAfterMs(int $pollAfterMs): self
    {
        $self = clone $this;
        $self['pollAfterMs'] = $pollAfterMs;

        return $self;
    }

    /**
     * @param 'pending' $status
     */
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
