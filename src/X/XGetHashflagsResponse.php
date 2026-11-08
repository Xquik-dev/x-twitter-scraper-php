<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Hashflag;

/**
 * @phpstan-type XGetHashflagsResponseShape = array{
 *   hashflags: list<Hashflag|array<string,mixed>>,
 *   count: int,
 *   total: int,
 *   message?: string|null,
 * }
 */
final class XGetHashflagsResponse implements BaseModel
{
    /** @use SdkModel<XGetHashflagsResponseShape> */
    use SdkModel;

    /**
     * @var list<Hashflag> $hashflags
     */
    #[Required(list: Hashflag::class)]
    public array $hashflags;

    /**
     * Hashflags returned & charged.
     */
    #[Required]
    public int $count;

    /**
     * Hashflags that match the filters, before limit.
     */
    #[Required]
    public int $total;

    /**
     * What to send instead. Present only when no hashflag matches.
     */
    #[Optional]
    public ?string $message;

    /**
     * `new XGetHashflagsResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XGetHashflagsResponse::with(hashflags: ..., count: ..., total: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XGetHashflagsResponse)->withHashflags(...)->withCount(...)->withTotal(...)
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
     * @param list<Hashflag|array<string,mixed>> $hashflags
     */
    public static function with(array $hashflags, int $count, int $total, ?string $message = null): self
    {
        $self = new self;

        $self['hashflags'] = $hashflags;
        $self['count'] = $count;
        $self['total'] = $total;

        null !== $message && $self['message'] = $message;

        return $self;
    }

    /**
     * @param list<Hashflag|array<string,mixed>> $hashflags
     */
    public function withHashflags(array $hashflags): self
    {
        $self = clone $this;
        $self['hashflags'] = $hashflags;

        return $self;
    }

    /**
     * Hashflags returned & charged.
     */
    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    /**
     * Hashflags that match the filters, before limit.
     */
    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }

    /**
     * What to send instead. Present only when no hashflag matches.
     */
    public function withMessage(?string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
