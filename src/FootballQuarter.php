<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type FootballQuarterShape = array{
 *   id: string|null,
 *   number: int|null,
 *   sequence: int|null,
 *   drives: list<FootballDrive|array<string,mixed>>,
 * }
 */
final class FootballQuarter implements BaseModel
{
    /** @use SdkModel<FootballQuarterShape> */
    use SdkModel;

    /**
     * X's ID for the quarter within the game.
     */
    #[Required]
    public ?string $id;

    /**
     * The quarter's number.
     */
    #[Required]
    public ?int $number;

    /**
     * The quarter's place in the game, from 1.
     */
    #[Required]
    public ?int $sequence;

    /**
     * The quarter's drives, in order.
     *
     * @var list<FootballDrive> $drives
     */
    #[Required(list: FootballDrive::class)]
    public array $drives;

    /**
     * `new FootballQuarter()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballQuarter::with(id: ..., number: ..., sequence: ..., drives: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballQuarter)->withId(...)->withNumber(...)->withSequence(...)->withDrives(...)
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
     * @param list<FootballDrive|array<string,mixed>> $drives
     */
    public static function with(?string $id, ?int $number, ?int $sequence, array $drives): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['number'] = $number;
        $self['sequence'] = $sequence;
        $self['drives'] = $drives;

        return $self;
    }

    /**
     * X's ID for the quarter within the game.
     */
    public function withId(?string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The quarter's number.
     */
    public function withNumber(?int $number): self
    {
        $self = clone $this;
        $self['number'] = $number;

        return $self;
    }

    /**
     * The quarter's place in the game, from 1.
     */
    public function withSequence(?int $sequence): self
    {
        $self = clone $this;
        $self['sequence'] = $sequence;

        return $self;
    }

    /**
     * The quarter's drives, in order.
     *
     * @param list<FootballDrive|array<string,mixed>> $drives
     */
    public function withDrives(array $drives): self
    {
        $self = clone $this;
        $self['drives'] = $drives;

        return $self;
    }
}
