<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Error\Error;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Error\Error\StructuredError\Code;
use XTwitterScraper\Error\Error\StructuredError\Type;

/**
 * @phpstan-type StructuredErrorShape = array{
 *   code: Code|value-of<Code>, message: string, type: Type|value-of<Type>
 * }
 */
final class StructuredError implements BaseModel
{
    /** @use SdkModel<StructuredErrorShape> */
    use SdkModel;

    /** @var value-of<Code> $code */
    #[Required(enum: Code::class)]
    public string $code;

    #[Required]
    public string $message;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new StructuredError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * StructuredError::with(code: ..., message: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new StructuredError)->withCode(...)->withMessage(...)->withType(...)
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
     * @param Code|value-of<Code> $code
     * @param Type|value-of<Type> $type
     */
    public static function with(
        Code|string $code,
        string $message,
        Type|string $type
    ): self {
        $self = new self;

        $self['code'] = $code;
        $self['message'] = $message;
        $self['type'] = $type;

        return $self;
    }

    /**
     * @param Code|value-of<Code> $code
     */
    public function withCode(Code|string $code): self
    {
        $self = clone $this;
        $self['code'] = $code;

        return $self;
    }

    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
