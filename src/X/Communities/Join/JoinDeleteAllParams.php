<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Communities\Join;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Leave community.
 *
 * @see XTwitterScraper\Services\X\Communities\JoinService::deleteAll()
 *
 * @phpstan-type JoinDeleteAllParamsShape = array{
 *   account: string, idempotencyKey: string
 * }
 */
final class JoinDeleteAllParams implements BaseModel
{
    /** @use SdkModel<JoinDeleteAllParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * X account identifier (@username or account ID).
     */
    #[Required]
    public string $account;

    #[Required]
    public string $idempotencyKey;

    /**
     * `new JoinDeleteAllParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * JoinDeleteAllParams::with(account: ..., idempotencyKey: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new JoinDeleteAllParams)->withAccount(...)->withIdempotencyKey(...)
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
    public static function with(string $account, string $idempotencyKey): self
    {
        $self = new self;

        $self['account'] = $account;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    /**
     * X account identifier (@username or account ID).
     */
    public function withAccount(string $account): self
    {
        $self = clone $this;
        $self['account'] = $account;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }
}
