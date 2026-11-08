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
use XTwitterScraper\TweetAnalysisQuestion\Criteria;
use XTwitterScraper\TweetAnalysisQuestion\Type;

/**
 * @phpstan-type TweetAnalysisQuestionShape = array{
 *   id: string,
 *   type: Type|value-of<Type>,
 *   version: string,
 *   instructions: string,
 *   categories?: array<string,mixed>|null,
 *   levels?: list<string>|null,
 *   criteria?: Criteria|array<string,mixed>|null,
 * }
 */
final class TweetAnalysisQuestion implements BaseModel
{
    /** @use SdkModel<TweetAnalysisQuestionShape> */
    use SdkModel;

    /**
     * Name of the answer, such as request. A name the response renames or drops gets a 400, such as created_at, favorite_count, muting or blocking.
     */
    #[Required]
    public string $id;

    /**
     * @var value-of<Type> $type
     */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Your version of the question, such as 1.
     */
    #[Required]
    public string $version;

    /**
     * The question, as the AI reads it.
     */
    #[Required]
    public string $instructions;

    /**
     * For a choice. Each category name with its description, or null.
     *
     * @var array<string,mixed>|null $categories
     */
    #[Optional(map: 'mixed')]
    public ?array $categories;

    /**
     * For a score. Each level's description, lowest first.
     *
     * @var list<string>|null $levels
     */
    #[Optional(list: 'string')]
    public ?array $levels;

    /**
     * For a probability. What counts as yes & as no.
     */
    #[Optional]
    public ?Criteria $criteria;

    /**
     * `new TweetAnalysisQuestion()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetAnalysisQuestion::with(id: ..., type: ..., version: ..., instructions: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetAnalysisQuestion)->withId(...)->withType(...)->withVersion(...)->withInstructions(...)
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
     * @param array<string,mixed>|null $categories
     * @param list<string>|null $levels
     * @param Criteria|array<string,mixed>|null $criteria
     */
    public static function with(string $id, Type|string $type, string $version, string $instructions, ?array $categories = null, ?array $levels = null, Criteria|array|null $criteria = null): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['type'] = $type;
        $self['version'] = $version;
        $self['instructions'] = $instructions;

        null !== $categories && $self['categories'] = $categories;
        null !== $levels && $self['levels'] = $levels;
        null !== $criteria && $self['criteria'] = $criteria;

        return $self;
    }

    /**
     * Name of the answer, such as request. A name the response renames or drops gets a 400, such as created_at, favorite_count, muting or blocking.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
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

    /**
     * Your version of the question, such as 1.
     */
    public function withVersion(string $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

        return $self;
    }

    /**
     * The question, as the AI reads it.
     */
    public function withInstructions(string $instructions): self
    {
        $self = clone $this;
        $self['instructions'] = $instructions;

        return $self;
    }

    /**
     * For a choice. Each category name with its description, or null.
     *
     * @param array<string,mixed>|null $categories
     */
    public function withCategories(?array $categories): self
    {
        $self = clone $this;
        $self['categories'] = $categories;

        return $self;
    }

    /**
     * For a score. Each level's description, lowest first.
     *
     * @param list<string>|null $levels
     */
    public function withLevels(?array $levels): self
    {
        $self = clone $this;
        $self['levels'] = $levels;

        return $self;
    }

    /**
     * For a probability. What counts as yes & as no.
     *
     * @param Criteria|array<string,mixed>|null $criteria
     */
    public function withCriteria(Criteria|array|null $criteria): self
    {
        $self = clone $this;
        $self['criteria'] = $criteria;

        return $self;
    }
}
