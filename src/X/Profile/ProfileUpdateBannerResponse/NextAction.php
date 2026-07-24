<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Profile\ProfileUpdateBannerResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Profile\ProfileUpdateBannerResponse\NextAction\Type;

/**
 * Exact follow-up an API client or agent should perform.
 *
 * @phpstan-type NextActionShape = array{
 *   type: Type|value-of<Type>,
 *   afterMs?: int|null,
 *   requiresNewIdempotencyKey?: bool|null,
 *   url?: string|null,
 * }
 */
final class NextAction implements BaseModel
{
    /** @use SdkModel<NextActionShape> */
    use SdkModel;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    #[Optional]
    public ?int $afterMs;

    #[Optional]
    public ?bool $requiresNewIdempotencyKey;

    #[Optional]
    public ?string $url;

    /**
     * `new NextAction()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * NextAction::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new NextAction)->withType(...)
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
    public static function with(
        Type|string $type,
        ?int $afterMs = null,
        ?bool $requiresNewIdempotencyKey = null,
        ?string $url = null,
    ): self {
        $self = new self;

        $self['type'] = $type;

        null !== $afterMs && $self['afterMs'] = $afterMs;
        null !== $requiresNewIdempotencyKey && $self['requiresNewIdempotencyKey'] = $requiresNewIdempotencyKey;
        null !== $url && $self['url'] = $url;

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

    public function withAfterMs(int $afterMs): self
    {
        $self = clone $this;
        $self['afterMs'] = $afterMs;

        return $self;
    }

    public function withRequiresNewIdempotencyKey(
        bool $requiresNewIdempotencyKey
    ): self {
        $self = clone $this;
        $self['requiresNewIdempotencyKey'] = $requiresNewIdempotencyKey;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
