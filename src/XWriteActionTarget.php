<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\XWriteActionTarget\Type;

/**
 * @phpstan-type XWriteActionTargetShape = array{
 *   type: Type|value-of<Type>,
 *   id: string,
 * }
 */
final class XWriteActionTarget implements BaseModel
{
    /** @use SdkModel<XWriteActionTargetShape> */
    use SdkModel;

    /**
     * @var value-of<Type> $type
     */
    #[Required(enum: Type::class)]
    public string $type;

    #[Required]
    public string $id;

    /**
     * `new XWriteActionTarget()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XWriteActionTarget::with(type: ..., id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XWriteActionTarget)->withType(...)->withId(...)
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
     * @param Type|value-of<Type> $type
     */
    public static function with(Type|string $type, string $id): self
    {
        $self = new self;

        $self['type'] = $type;
        $self['id'] = $id;

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

    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }
}
