<?php

declare(strict_types=1);

namespace XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * The account connected successfully.
 *
 * @phpstan-type XAccountConnectionAttemptSuccessShape = array{
 *   id: string, object: 'x_account_connection_attempt', status: 'success'
 * }
 */
final class XAccountConnectionAttemptSuccess implements BaseModel
{
    /** @use SdkModel<XAccountConnectionAttemptSuccessShape> */
    use SdkModel;

    /** @var 'x_account_connection_attempt' $object */
    #[Required]
    public string $object = 'x_account_connection_attempt';

    /** @var 'success' $status */
    #[Required]
    public string $status = 'success';

    #[Required]
    public string $id;

    /**
     * `new XAccountConnectionAttemptSuccess()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XAccountConnectionAttemptSuccess::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XAccountConnectionAttemptSuccess)->withID(...)
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
    public static function with(string $id): self
    {
        $self = new self;

        $self['id'] = $id;

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

    /**
     * @param 'success' $status
     */
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
