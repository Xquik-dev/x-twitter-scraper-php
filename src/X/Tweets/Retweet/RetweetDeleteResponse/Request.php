<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\Retweet\RetweetDeleteResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Stable fingerprint and sanitized payload for replay checks.
 *
 * @phpstan-type RequestShape = array{
 *   hash: string|null, payload: array<string,mixed>|null
 * }
 */
final class Request implements BaseModel
{
    /** @use SdkModel<RequestShape> */
    use SdkModel;

    /**
     * Stable hash of account, action, target, and payload.
     */
    #[Required]
    public ?string $hash;

    /**
     * Exact sanitized payload dispatched for this action.
     *
     * @var array<string,mixed>|null $payload
     */
    #[Required(map: 'mixed')]
    public ?array $payload;

    /**
     * `new Request()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Request::with(hash: ..., payload: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Request)->withHash(...)->withPayload(...)
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
     * @param array<string,mixed>|null $payload
     */
    public static function with(?string $hash, ?array $payload): self
    {
        $self = new self;

        $self['hash'] = $hash;
        $self['payload'] = $payload;

        return $self;
    }

    /**
     * Stable hash of account, action, target, and payload.
     */
    public function withHash(?string $hash): self
    {
        $self = clone $this;
        $self['hash'] = $hash;

        return $self;
    }

    /**
     * Exact sanitized payload dispatched for this action.
     *
     * @param array<string,mixed>|null $payload
     */
    public function withPayload(?array $payload): self
    {
        $self = clone $this;
        $self['payload'] = $payload;

        return $self;
    }
}
