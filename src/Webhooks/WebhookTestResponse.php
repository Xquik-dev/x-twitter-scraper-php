<?php

declare(strict_types=1);

namespace XTwitterScraper\Webhooks;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type WebhookTestResponseShape = array{
 *   statusCode: int, success: bool, error?: string|null
 * }
 */
final class WebhookTestResponse implements BaseModel
{
    /** @use SdkModel<WebhookTestResponseShape> */
    use SdkModel;

    #[Required]
    public int $statusCode;

    #[Required]
    public bool $success;

    #[Optional]
    public ?string $error;

    /**
     * `new WebhookTestResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebhookTestResponse::with(statusCode: ..., success: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebhookTestResponse)->withStatusCode(...)->withSuccess(...)
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
        int $statusCode,
        bool $success,
        ?string $error = null
    ): self {
        $self = new self;

        $self['statusCode'] = $statusCode;
        $self['success'] = $success;

        null !== $error && $self['error'] = $error;

        return $self;
    }

    public function withStatusCode(int $statusCode): self
    {
        $self = clone $this;
        $self['statusCode'] = $statusCode;

        return $self;
    }

    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }

    public function withError(string $error): self
    {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }
}
