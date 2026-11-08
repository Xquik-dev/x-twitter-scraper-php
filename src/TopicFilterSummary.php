<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\TopicFilterSummary\Unchecked;

/**
 * What the topic filter asked & how many posts it kept.
 *
 * @phpstan-import-type UncheckedShape from \XTwitterScraper\TopicFilterSummary\Unchecked
 *
 * @phpstan-type TopicFilterSummaryShape = array{
 *   topic: string,
 *   question: string,
 *   cutoff: float,
 *   checked: int,
 *   kept: int,
 *   unchecked: list<Unchecked|UncheckedShape>,
 * }
 */
final class TopicFilterSummary implements BaseModel
{
    /** @use SdkModel<TopicFilterSummaryShape> */
    use SdkModel;

    /**
     * The topic you sent.
     */
    #[Required]
    public string $topic;

    /**
     * The question asked of each post.
     */
    #[Required]
    public string $question;

    /**
     * The lowest topicScore a kept post has.
     */
    #[Required]
    public float $cutoff;

    /**
     * Posts checked. Only kept posts are billed.
     */
    #[Required]
    public int $checked;

    /**
     * Posts about the topic, all returned & billed at 2 credits each.
     */
    #[Required]
    public int $kept;

    /**
     * Posts the check couldn't answer. They aren't billed or returned.
     *
     * @var list<Unchecked> $unchecked
     */
    #[Required(list: Unchecked::class)]
    public array $unchecked;

    /**
     * `new TopicFilterSummary()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TopicFilterSummary::with(topic: ..., question: ..., cutoff: ..., checked: ..., kept: ..., unchecked: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TopicFilterSummary)
     *   ->withTopic(...)
     *   ->withQuestion(...)
     *   ->withCutoff(...)
     *   ->withChecked(...)
     *   ->withKept(...)
     *   ->withUnchecked(...)
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
     * @param list<Unchecked|UncheckedShape> $unchecked
     */
    public static function with(
        string $topic,
        string $question,
        float $cutoff,
        int $checked,
        int $kept,
        array $unchecked,
    ): self {
        $self = new self;

        $self['topic'] = $topic;
        $self['question'] = $question;
        $self['cutoff'] = $cutoff;
        $self['checked'] = $checked;
        $self['kept'] = $kept;
        $self['unchecked'] = $unchecked;

        return $self;
    }

    /**
     * The topic you sent.
     */
    public function withTopic(string $topic): self
    {
        $self = clone $this;
        $self['topic'] = $topic;

        return $self;
    }

    /**
     * The question asked of each post.
     */
    public function withQuestion(string $question): self
    {
        $self = clone $this;
        $self['question'] = $question;

        return $self;
    }

    /**
     * The lowest topicScore a kept post has.
     */
    public function withCutoff(float $cutoff): self
    {
        $self = clone $this;
        $self['cutoff'] = $cutoff;

        return $self;
    }

    /**
     * Posts checked. Only kept posts are billed.
     */
    public function withChecked(int $checked): self
    {
        $self = clone $this;
        $self['checked'] = $checked;

        return $self;
    }

    /**
     * Posts about the topic, all returned & billed at 2 credits each.
     */
    public function withKept(int $kept): self
    {
        $self = clone $this;
        $self['kept'] = $kept;

        return $self;
    }

    /**
     * Posts the check couldn't answer. They aren't billed or returned.
     *
     * @param list<Unchecked|UncheckedShape> $unchecked
     */
    public function withUnchecked(array $unchecked): self
    {
        $self = clone $this;
        $self['unchecked'] = $unchecked;

        return $self;
    }
}
