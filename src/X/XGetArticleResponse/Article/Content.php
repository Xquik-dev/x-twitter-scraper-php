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
use XTwitterScraper\X\XGetArticleResponse\Article\Content\Links;
use XTwitterScraper\X\XGetArticleResponse\Article\Content\MediaType;
use XTwitterScraper\X\XGetArticleResponse\Article\Content\Variants;

/**
 * @phpstan-import-type InlineStyleRangeShape from InlineStyleRange
 *
 * @phpstan-type ContentShape = array{
 *   height?: int|null,
 *   inlineStyleRanges?: list<InlineStyleRange|InlineStyleRangeShape>|null,
 *   previewURL?: string|null,
 *   text?: string|null,
 *   type?: string|null,
 *   url?: string|null,
 *   width?: int|null,
 *   tweetID?: string|null,
 *   links?: list<Links|array<string,mixed>>|null,
 *   mediaType?: MediaType|value-of<MediaType>|null,
 *   caption?: string|null,
 *   altText?: string|null,
 *   durationMs?: int|null,
 *   variants?: list<Variants|array<string,mixed>>|null,
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

    /**
     * ID of the post a tweet block embeds.
     */
    #[Optional('tweetId')]
    public ?string $tweetID;

    /**
     * Links in the block's text, with the text range each covers.
     *
     * @var list<Links>|null $links
     */
    #[Optional(list: Links::class)]
    public ?array $links;

    /**
     * What a media block holds.
     *
     * @var value-of<MediaType>|null $mediaType
     */
    #[Optional(enum: MediaType::class)]
    public ?string $mediaType;

    /**
     * Caption the author wrote under a media block.
     */
    #[Optional]
    public ?string $caption;

    /**
     * Alt text of the image or preview image.
     */
    #[Optional]
    public ?string $altText;

    /**
     * Length of a video, in milliseconds.
     */
    #[Optional]
    public ?int $durationMs;

    /**
     * Files of a video or GIF block, in X's order.
     *
     * @var list<Variants>|null $variants
     */
    #[Optional(list: Variants::class)]
    public ?array $variants;

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
     * @param list<Links|array<string,mixed>>|null $links
     * @param MediaType|value-of<MediaType>|null $mediaType
     * @param list<Variants|array<string,mixed>>|null $variants
     */
    public static function with(
        ?int $height = null,
        ?array $inlineStyleRanges = null,
        ?string $previewURL = null,
        ?string $text = null,
        ?string $type = null,
        ?string $url = null,
        ?int $width = null,
        ?string $tweetID = null,
        ?array $links = null,
        MediaType|string|null $mediaType = null,
        ?string $caption = null,
        ?string $altText = null,
        ?int $durationMs = null,
        ?array $variants = null
    ): self {
        $self = new self;

        null !== $height && $self['height'] = $height;
        null !== $inlineStyleRanges && $self['inlineStyleRanges'] = $inlineStyleRanges;
        null !== $previewURL && $self['previewURL'] = $previewURL;
        null !== $text && $self['text'] = $text;
        null !== $type && $self['type'] = $type;
        null !== $url && $self['url'] = $url;
        null !== $width && $self['width'] = $width;

        null !== $tweetID && $self['tweetID'] = $tweetID;

        null !== $links && $self['links'] = $links;

        null !== $mediaType && $self['mediaType'] = $mediaType;

        null !== $caption && $self['caption'] = $caption;

        null !== $altText && $self['altText'] = $altText;

        null !== $durationMs && $self['durationMs'] = $durationMs;

        null !== $variants && $self['variants'] = $variants;

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

    /**
     * ID of the post a tweet block embeds.
     */
    public function withTweetID(?string $tweetID): self
    {
        $self = clone $this;
        $self['tweetID'] = $tweetID;

        return $self;
    }

    /**
     * Links in the block's text, with the text range each covers.
     *
     * @param list<Links|array<string,mixed>>|null $links
     */
    public function withLinks(?array $links): self
    {
        $self = clone $this;
        $self['links'] = $links;

        return $self;
    }

    /**
     * What a media block holds.
     *
     * @param MediaType|value-of<MediaType>|null $mediaType
     */
    public function withMediaType(MediaType|string|null $mediaType): self
    {
        $self = clone $this;
        $self['mediaType'] = $mediaType;

        return $self;
    }

    /**
     * Caption the author wrote under a media block.
     */
    public function withCaption(?string $caption): self
    {
        $self = clone $this;
        $self['caption'] = $caption;

        return $self;
    }

    /**
     * Alt text of the image or preview image.
     */
    public function withAltText(?string $altText): self
    {
        $self = clone $this;
        $self['altText'] = $altText;

        return $self;
    }

    /**
     * Length of a video, in milliseconds.
     */
    public function withDurationMs(?int $durationMs): self
    {
        $self = clone $this;
        $self['durationMs'] = $durationMs;

        return $self;
    }

    /**
     * Files of a video or GIF block, in X's order.
     *
     * @param list<Variants|array<string,mixed>>|null $variants
     */
    public function withVariants(?array $variants): self
    {
        $self = clone $this;
        $self['variants'] = $variants;

        return $self;
    }
}
