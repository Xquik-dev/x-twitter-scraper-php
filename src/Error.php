<?php

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Error response containing a machine-readable error code.
 *
 * @phpstan-type ErrorShape = array{
 *   error: \XTwitterScraper\Error\Error|value-of<\XTwitterScraper\Error\Error>
 * }
 */
final class Error implements BaseModel
{
    /** @use SdkModel<ErrorShape> */
    use SdkModel;

    /** @var value-of<Error\Error> $error */
    #[Required(enum: Error\Error::class)]
    public string $error;

    /**
     * `new Error()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Error::with(error: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Error)->withError(...)
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
     * @param Error\Error|value-of<Error\Error> $error
     */
    public static function with(
        Error\Error|string $error
    ): self {
        $self = new self;

        $self['error'] = $error;

        return $self;
    }

    /**
     * @param Error\Error|value-of<Error\Error> $error
     */
    public function withError(Error\Error|string $error): self
    {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }
}
