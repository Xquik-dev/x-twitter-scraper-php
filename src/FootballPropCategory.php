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
 * @phpstan-type FootballPropCategoryShape = array{
 *   key: string|null,
 *   name: string|null,
 *   rank: float|null,
 *   props: list<FootballPlayerProp|array<string,mixed>>,
 * }
 */
final class FootballPropCategory implements BaseModel
{
    /** @use SdkModel<FootballPropCategoryShape> */
    use SdkModel;

    /**
     * X's key for the prop, such as passing_yards.
     */
    #[Required]
    public ?string $key;

    /**
     * The name X shows for the prop.
     */
    #[Required]
    public ?string $name;

    /**
     * The category's place in X's order, from 1.
     */
    #[Required]
    public ?float $rank;

    /**
     * Each player's line, in X's order.
     *
     * @var list<FootballPlayerProp> $props
     */
    #[Required(list: FootballPlayerProp::class)]
    public array $props;

    /**
     * `new FootballPropCategory()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballPropCategory::with(key: ..., name: ..., rank: ..., props: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballPropCategory)->withKey(...)->withName(...)->withRank(...)->withProps(...)
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
     * @param list<FootballPlayerProp|array<string,mixed>> $props
     */
    public static function with(?string $key, ?string $name, ?float $rank, array $props): self
    {
        $self = new self;

        $self['key'] = $key;
        $self['name'] = $name;
        $self['rank'] = $rank;
        $self['props'] = $props;

        return $self;
    }

    /**
     * X's key for the prop, such as passing_yards.
     */
    public function withKey(?string $key): self
    {
        $self = clone $this;
        $self['key'] = $key;

        return $self;
    }

    /**
     * The name X shows for the prop.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * The category's place in X's order, from 1.
     */
    public function withRank(?float $rank): self
    {
        $self = clone $this;
        $self['rank'] = $rank;

        return $self;
    }

    /**
     * Each player's line, in X's order.
     *
     * @param list<FootballPlayerProp|array<string,mixed>> $props
     */
    public function withProps(array $props): self
    {
        $self = clone $this;
        $self['props'] = $props;

        return $self;
    }
}
