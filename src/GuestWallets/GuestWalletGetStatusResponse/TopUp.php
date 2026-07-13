<?php

declare(strict_types=1);

namespace XTwitterScraper\GuestWallets\GuestWalletGetStatusResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Top-up action when usable and no checkout is pending.
 *
 * @phpstan-type TopUpShape = array{
 *   method: 'POST', path: '/api/v1/guest-wallets/topups'
 * }
 */
final class TopUp implements BaseModel
{
    /** @use SdkModel<TopUpShape> */
    use SdkModel;

    /** @var 'POST' $method */
    #[Required]
    public string $method = 'POST';

    /** @var '/api/v1/guest-wallets/topups' $path */
    #[Required]
    public string $path = '/api/v1/guest-wallets/topups';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * @param 'POST' $method
     */
    public function withMethod(string $method): self
    {
        $self = clone $this;
        $self['method'] = $method;

        return $self;
    }

    /**
     * @param '/api/v1/guest-wallets/topups' $path
     */
    public function withPath(string $path): self
    {
        $self = clone $this;
        $self['path'] = $path;

        return $self;
    }
}
