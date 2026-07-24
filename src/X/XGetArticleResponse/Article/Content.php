<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\XGetArticleResponse\Article;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\XGetArticleResponse\Article\Content\InlineStyleRange;

/**
 * @phpstan-import-type InlineStyleRangeShape from \XTwitterScraper\X\XGetArticleResponse\Article\Content\InlineStyleRange
 *
 * @phpstan-type ContentShape = array{
 *   height?: int|null,
 *   inlineStyleRanges?: list<InlineStyleRange|InlineStyleRangeShape>|null,
 *   previewURL?: string|null,
 *   text?: string|null,
 *   type?: string|null,
 *   url?: string|null,
 *   width?: int|null,
 * }
 */
final class Content implements BaseModel
{
    /** @use SdkModel<ContentShape> */
    use SdkModel;

    #[Optional]
    public ?int $height;

    /**
     * Inline text formatting ranges.
     *
     * @var list<InlineStyleRange>|null $inlineStyleRanges
     */
    #[Optional(list: InlineStyleRange::class)]
    public ?array $inlineStyleRanges;

    /**
     * Preview image URL for media blocks.
     */
    #[Optional('previewUrl')]
    public ?string $previewURL;

    #[Optional]
    public ?string $text;

    /**
     * Block type: paragraph, header-one, header-two, header-three, header-four, header-five, header-six, unordered-list-item, ordered-list-item, blockquote, code-block, media, divider.
     */
    #[Optional]
    public ?string $type;

    /**
     * Media URL for media blocks.
     */
    #[Optional]
    public ?string $url;

    #[Optional]
    public ?int $width;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<InlineStyleRange|InlineStyleRangeShape>|null $inlineStyleRanges
     */
    public static function with(
        ?int $height = null,
        ?array $inlineStyleRanges = null,
        ?string $previewURL = null,
        ?string $text = null,
        ?string $type = null,
        ?string $url = null,
        ?int $width = null,
    ): self {
        $self = new self;

        null !== $height && $self['height'] = $height;
        null !== $inlineStyleRanges && $self['inlineStyleRanges'] = $inlineStyleRanges;
        null !== $previewURL && $self['previewURL'] = $previewURL;
        null !== $text && $self['text'] = $text;
        null !== $type && $self['type'] = $type;
        null !== $url && $self['url'] = $url;
        null !== $width && $self['width'] = $width;

        return $self;
    }

    public function withHeight(int $height): self
    {
        $self = clone $this;
        $self['height'] = $height;

        return $self;
    }

    /**
     * Inline text formatting ranges.
     *
     * @param list<InlineStyleRange|InlineStyleRangeShape> $inlineStyleRanges
     */
    public function withInlineStyleRanges(array $inlineStyleRanges): self
    {
        $self = clone $this;
        $self['inlineStyleRanges'] = $inlineStyleRanges;

        return $self;
    }

    /**
     * Preview image URL for media blocks.
     */
    public function withPreviewURL(string $previewURL): self
    {
        $self = clone $this;
        $self['previewURL'] = $previewURL;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * Block type: paragraph, header-one, header-two, header-three, header-four, header-five, header-six, unordered-list-item, ordered-list-item, blockquote, code-block, media, divider.
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Media URL for media blocks.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    public function withWidth(int $width): self
    {
        $self = clone $this;
        $self['width'] = $width;

        return $self;
    }
}
