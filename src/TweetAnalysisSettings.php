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
use XTwitterScraper\TweetAnalysisSettings\Preset;
use XTwitterScraper\TweetAnalysisSettings\Targets;

/**
 * @phpstan-type TweetAnalysisSettingsShape = array{
 *   questions?: list<TweetAnalysisQuestion|array<string,mixed>>|null,
 *   preset?: Preset|value-of<Preset>|null,
 *   targets?: list<Targets|array<string,mixed>>|null,
 *   context?: string|null,
 *   maxContextBytes?: int|null,
 *   concurrency?: int|null,
 *   images?: bool|null,
 * }
 */
final class TweetAnalysisSettings implements BaseModel
{
    /** @use SdkModel<TweetAnalysisSettingsShape> */
    use SdkModel;

    /**
     * Your own questions, which replace the route's questions. Write question IDs & category names in lower case without hyphens.
     *
     * @var list<TweetAnalysisQuestion>|null $questions
     */
    #[Optional(list: TweetAnalysisQuestion::class)]
    public ?array $questions;

    /**
     * A ready set of questions, used when questions is left out. complaints, competitors, purchase_intent & product_feedback need targets. viral_lite scores how viral the wording reads.
     *
     * @var value-of<Preset>|null $preset
     */
    #[Optional(enum: Preset::class)]
    public ?string $preset;

    /**
     * Brands, people, assets or topics the questions are about, each with its aliases.
     *
     * @var list<Targets>|null $targets
     */
    #[Optional(list: Targets::class)]
    public ?array $targets;

    /**
     * Background the AI reads with every post.
     */
    #[Optional]
    public ?string $context;

    /**
     * Bytes of post, quote & settings the AI reads. Xquik cuts longer posts to fit. Empty settings take 219 bytes, so a smaller value gets a 400.
     */
    #[Optional]
    public ?int $maxContextBytes;

    /**
     * Posts analyzed at the same time.
     */
    #[Optional]
    public ?int $concurrency;

    /**
     * Reads up to 4 images per post with its text, at no extra cost. Images of posts X marks sensitive stay unread. Send false to analyze the text alone.
     */
    #[Optional]
    public ?bool $images;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<TweetAnalysisQuestion|array<string,mixed>>|null $questions
     * @param Preset|value-of<Preset>|null $preset
     * @param list<Targets|array<string,mixed>>|null $targets
     */
    public static function with(?array $questions = null, Preset|string|null $preset = null, ?array $targets = null, ?string $context = null, ?int $maxContextBytes = null, ?int $concurrency = null, ?bool $images = null): self
    {
        $self = new self;

        null !== $questions && $self['questions'] = $questions;
        null !== $preset && $self['preset'] = $preset;
        null !== $targets && $self['targets'] = $targets;
        null !== $context && $self['context'] = $context;
        null !== $maxContextBytes && $self['maxContextBytes'] = $maxContextBytes;
        null !== $concurrency && $self['concurrency'] = $concurrency;
        null !== $images && $self['images'] = $images;

        return $self;
    }

    /**
     * Your own questions, which replace the route's questions. Write question IDs & category names in lower case without hyphens.
     *
     * @param list<TweetAnalysisQuestion|array<string,mixed>>|null $questions
     */
    public function withQuestions(?array $questions): self
    {
        $self = clone $this;
        $self['questions'] = $questions;

        return $self;
    }

    /**
     * A ready set of questions, used when questions is left out. complaints, competitors, purchase_intent & product_feedback need targets. viral_lite scores how viral the wording reads.
     *
     * @param Preset|value-of<Preset>|null $preset
     */
    public function withPreset(Preset|string|null $preset): self
    {
        $self = clone $this;
        $self['preset'] = $preset;

        return $self;
    }

    /**
     * Brands, people, assets or topics the questions are about, each with its aliases.
     *
     * @param list<Targets|array<string,mixed>>|null $targets
     */
    public function withTargets(?array $targets): self
    {
        $self = clone $this;
        $self['targets'] = $targets;

        return $self;
    }

    /**
     * Background the AI reads with every post.
     */
    public function withContext(?string $context): self
    {
        $self = clone $this;
        $self['context'] = $context;

        return $self;
    }

    /**
     * Bytes of post, quote & settings the AI reads. Xquik cuts longer posts to fit. Empty settings take 219 bytes, so a smaller value gets a 400.
     */
    public function withMaxContextBytes(?int $maxContextBytes): self
    {
        $self = clone $this;
        $self['maxContextBytes'] = $maxContextBytes;

        return $self;
    }

    /**
     * Posts analyzed at the same time.
     */
    public function withConcurrency(?int $concurrency): self
    {
        $self = clone $this;
        $self['concurrency'] = $concurrency;

        return $self;
    }

    /**
     * Reads up to 4 images per post with its text, at no extra cost. Images of posts X marks sensitive stay unread. Send false to analyze the text alone.
     */
    public function withImages(?bool $images): self
    {
        $self = clone $this;
        $self['images'] = $images;

        return $self;
    }
}
