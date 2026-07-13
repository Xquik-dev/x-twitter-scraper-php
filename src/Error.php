<?php

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Error\Error\LegacyErrorCode;
use XTwitterScraper\Error\Error\StructuredError;

/**
 * Error response. Default v1 returns a legacy string error code. Send `xquik-api-contract: 2026-04-29` to receive the structured best-practice error object.
 *
 * @phpstan-import-type ErrorVariants from \XTwitterScraper\Error\Error
 * @phpstan-import-type ErrorShape from \XTwitterScraper\Error\Error as ErrorShape1
 *
 * @phpstan-type ErrorShape = array{error: ErrorShape1}
 */
final class Error implements BaseModel
{
    /** @use SdkModel<ErrorShape> */
    use SdkModel;

    /** @var ErrorVariants $error */
    #[Required(union: Error\Error::class)]
    public StructuredError|string $error;

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
     * @param ErrorShape1 $error
     */
    public static function with(
        LegacyErrorCode|StructuredError|array|string $error
    ): self {
        $self = new self;

        $self['error'] = $error;

        return $self;
    }

    /**
     * @param ErrorShape1 $error
     */
    public function withError(
        LegacyErrorCode|StructuredError|array|string $error
    ): self {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }
}
