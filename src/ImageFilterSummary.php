<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\ImageFilterSummary\Unchecked;

/**
 * What the image filter asked & how many posts it kept.
 *
 * @phpstan-import-type UncheckedShape from \XTwitterScraper\ImageFilterSummary\Unchecked
 *
 * @phpstan-type ImageFilterSummaryShape = array{
 *   imageShows: string,
 *   question: string,
 *   cutoff: float,
 *   checked: int,
 *   kept: int,
 *   unchecked: list<Unchecked|UncheckedShape>,
 * }
 */
final class ImageFilterSummary implements BaseModel
{
    /** @use SdkModel<ImageFilterSummaryShape> */
    use SdkModel;

    /**
     * What you asked the photos to show.
     */
    #[Required]
    public string $imageShows;

    /**
     * The question asked of each post's photos.
     */
    #[Required]
    public string $question;

    /**
     * The lowest imageScore a kept post has.
     */
    #[Required]
    public float $cutoff;

    /**
     * Posts whose photos were checked. Only kept posts are billed.
     */
    #[Required]
    public int $checked;

    /**
     * Posts whose photos show it, all returned & billed at 2 credits each.
     */
    #[Required]
    public int $kept;

    /**
     * Posts without a safe photo & posts the check couldn't answer. They aren't billed or returned.
     *
     * @var list<Unchecked> $unchecked
     */
    #[Required(list: Unchecked::class)]
    public array $unchecked;

    /**
     * `new ImageFilterSummary()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ImageFilterSummary::with(imageShows: ..., question: ..., cutoff: ..., checked: ..., kept: ..., unchecked: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ImageFilterSummary)
     *   ->withImageShows(...)
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
        string $imageShows,
        string $question,
        float $cutoff,
        int $checked,
        int $kept,
        array $unchecked,
    ): self {
        $self = new self;

        $self['imageShows'] = $imageShows;
        $self['question'] = $question;
        $self['cutoff'] = $cutoff;
        $self['checked'] = $checked;
        $self['kept'] = $kept;
        $self['unchecked'] = $unchecked;

        return $self;
    }

    /**
     * What you asked the photos to show.
     */
    public function withImageShows(string $imageShows): self
    {
        $self = clone $this;
        $self['imageShows'] = $imageShows;

        return $self;
    }

    /**
     * The question asked of each post's photos.
     */
    public function withQuestion(string $question): self
    {
        $self = clone $this;
        $self['question'] = $question;

        return $self;
    }

    /**
     * The lowest imageScore a kept post has.
     */
    public function withCutoff(float $cutoff): self
    {
        $self = clone $this;
        $self['cutoff'] = $cutoff;

        return $self;
    }

    /**
     * Posts whose photos were checked. Only kept posts are billed.
     */
    public function withChecked(int $checked): self
    {
        $self = clone $this;
        $self['checked'] = $checked;

        return $self;
    }

    /**
     * Posts whose photos show it, all returned & billed at 2 credits each.
     */
    public function withKept(int $kept): self
    {
        $self = clone $this;
        $self['kept'] = $kept;

        return $self;
    }

    /**
     * Posts without a safe photo & posts the check couldn't answer. They aren't billed or returned.
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
