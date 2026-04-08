<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Accounts;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type AccountBulkRetryResponseShape = array{cleared: int}
 */
final class AccountBulkRetryResponse implements BaseModel
{
    /** @use SdkModel<AccountBulkRetryResponseShape> */
    use SdkModel;

    /**
     * Number of accounts cleared.
     */
    #[Required]
    public int $cleared;

    /**
     * `new AccountBulkRetryResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AccountBulkRetryResponse::with(cleared: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AccountBulkRetryResponse)->withCleared(...)
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
    public static function with(int $cleared): self
    {
        $self = new self;

        $self['cleared'] = $cleared;

        return $self;
    }

    /**
     * Number of accounts cleared.
     */
    public function withCleared(int $cleared): self
    {
        $self = clone $this;
        $self['cleared'] = $cleared;

        return $self;
    }
}
