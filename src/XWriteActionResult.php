<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\XWriteActionResult\Type;

/**
 * @phpstan-type XWriteActionResultShape = array{
 *   type?: Type|value-of<Type>|null,
 *   id?: string|null,
 *   state?: string|null,
 * }
 */
final class XWriteActionResult implements BaseModel
{
    /** @use SdkModel<XWriteActionResultShape> */
    use SdkModel;

    /**
     * @var value-of<Type>|null $type
     */
    #[Optional(enum: Type::class)]
    public ?string $type;

    #[Optional]
    public ?string $id;

    #[Optional]
    public ?string $state;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Type|value-of<Type>|null $type
     */
    public static function with(Type|string|null $type = null, ?string $id = null, ?string $state = null): self
    {
        $self = new self;

        null !== $type && $self['type'] = $type;
        null !== $id && $self['id'] = $id;
        null !== $state && $self['state'] = $state;

        return $self;
    }

    /**
     * @param Type|value-of<Type>|null $type
     */
    public function withType(Type|string|null $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    public function withId(?string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withState(?string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }
}
