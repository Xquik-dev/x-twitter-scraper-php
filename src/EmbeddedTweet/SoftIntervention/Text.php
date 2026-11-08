<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\EmbeddedTweet\SoftIntervention;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\EmbeddedTweet\SoftIntervention\Text\Entities;

/**
 * @phpstan-type TextShape = array{
 *   text?: string|null,
 *   rtl?: bool|null,
 *   entities?: list<Entities|array<string,mixed>>|null,
 * }
 */
final class Text implements BaseModel
{
    /** @use SdkModel<TextShape> */
    use SdkModel;

    /**
     * The label's text.
     */
    #[Optional]
    public ?string $text;

    /**
     * Whether the label reads right to left.
     */
    #[Optional]
    public ?bool $rtl;

    /**
     * Links inside the label, by character range.
     *
     * @var list<Entities>|null $entities
     */
    #[Optional(list: Entities::class)]
    public ?array $entities;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Entities|array<string,mixed>>|null $entities
     */
    public static function with(?string $text = null, ?bool $rtl = null, ?array $entities = null): self
    {
        $self = new self;

        null !== $text && $self['text'] = $text;
        null !== $rtl && $self['rtl'] = $rtl;
        null !== $entities && $self['entities'] = $entities;

        return $self;
    }

    /**
     * The label's text.
     */
    public function withText(?string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * Whether the label reads right to left.
     */
    public function withRtl(?bool $rtl): self
    {
        $self = clone $this;
        $self['rtl'] = $rtl;

        return $self;
    }

    /**
     * Links inside the label, by character range.
     *
     * @param list<Entities|array<string,mixed>>|null $entities
     */
    public function withEntities(?array $entities): self
    {
        $self = clone $this;
        $self['entities'] = $entities;

        return $self;
    }
}
