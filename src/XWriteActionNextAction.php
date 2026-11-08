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
use XTwitterScraper\XWriteActionNextAction\Type;

/**
 * @phpstan-type XWriteActionNextActionShape = array{
 *   type: Type|value-of<Type>,
 *   url?: string|null,
 *   afterMs?: int|null,
 *   requiresNewIdempotencyKey?: bool|null,
 * }
 */
final class XWriteActionNextAction implements BaseModel
{
    /** @use SdkModel<XWriteActionNextActionShape> */
    use SdkModel;

    /**
     * @var value-of<Type> $type
     */
    #[Required(enum: Type::class)]
    public string $type;

    #[Optional]
    public ?string $url;

    /**
     * Milliseconds to wait before you poll or retry.
     */
    #[Optional]
    public ?int $afterMs;

    #[Optional]
    public ?bool $requiresNewIdempotencyKey;

    /**
     * `new XWriteActionNextAction()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XWriteActionNextAction::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XWriteActionNextAction)->withType(...)
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
    public static function with(Type|string $type, ?string $url = null, ?int $afterMs = null, ?bool $requiresNewIdempotencyKey = null): self
    {
        $self = new self;

        $self['type'] = $type;

        null !== $url && $self['url'] = $url;
        null !== $afterMs && $self['afterMs'] = $afterMs;
        null !== $requiresNewIdempotencyKey && $self['requiresNewIdempotencyKey'] = $requiresNewIdempotencyKey;

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

    public function withUrl(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Milliseconds to wait before you poll or retry.
     */
    public function withAfterMs(?int $afterMs): self
    {
        $self = clone $this;
        $self['afterMs'] = $afterMs;

        return $self;
    }

    public function withRequiresNewIdempotencyKey(?bool $requiresNewIdempotencyKey): self
    {
        $self = clone $this;
        $self['requiresNewIdempotencyKey'] = $requiresNewIdempotencyKey;

        return $self;
    }
}
