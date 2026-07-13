<?php

declare(strict_types=1);

namespace XTwitterScraper\GuestWallets\GuestWalletTopupResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type AuthorizationShape = array{
 *   header: 'Authorization', scheme: 'Bearer'
 * }
 */
final class Authorization implements BaseModel
{
    /** @use SdkModel<AuthorizationShape> */
    use SdkModel;

    /** @var 'Authorization' $header */
    #[Required]
    public string $header = 'Authorization';

    /** @var 'Bearer' $scheme */
    #[Required]
    public string $scheme = 'Bearer';

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
     * @param 'Authorization' $header
     */
    public function withHeader(string $header): self
    {
        $self = clone $this;
        $self['header'] = $header;

        return $self;
    }

    /**
     * @param 'Bearer' $scheme
     */
    public function withScheme(string $scheme): self
    {
        $self = clone $this;
        $self['scheme'] = $scheme;

        return $self;
    }
}
