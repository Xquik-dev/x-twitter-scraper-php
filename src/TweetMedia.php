<?php

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Core\Conversion\ListOf;
use XTwitterScraper\TweetMedia\FaceRect;
use XTwitterScraper\TweetMedia\FocusRect;
use XTwitterScraper\TweetMedia\Size;
use XTwitterScraper\TweetMedia\Type;
use XTwitterScraper\TweetMedia\VideoVariant;

/**
 * Normalized media attached to a tweet.
 *
 * @phpstan-import-type FaceRectShape from \XTwitterScraper\TweetMedia\FaceRect
 * @phpstan-import-type FocusRectShape from \XTwitterScraper\TweetMedia\FocusRect
 * @phpstan-import-type SizeShape from \XTwitterScraper\TweetMedia\Size
 * @phpstan-import-type VideoVariantShape from \XTwitterScraper\TweetMedia\VideoVariant
 *
 * @phpstan-type TweetMediaShape = array{
 *   mediaURL: string,
 *   type: Type|value-of<Type>,
 *   url: string,
 *   id?: string|null,
 *   allowDownload?: bool|null,
 *   altText?: string|null,
 *   aspectRatio?: list<int>|null,
 *   availabilityStatus?: string|null,
 *   displayURL?: string|null,
 *   durationMillis?: int|null,
 *   expandedURL?: string|null,
 *   faceRects?: array<string,list<FaceRect|FaceRectShape>>|null,
 *   focusRects?: list<FocusRect|FocusRectShape>|null,
 *   height?: int|null,
 *   indices?: list<int>|null,
 *   mediaKey?: string|null,
 *   monetizable?: bool|null,
 *   sizes?: array<string,Size|SizeShape>|null,
 *   videoVariants?: list<VideoVariant|VideoVariantShape>|null,
 *   width?: int|null,
 * }
 */
final class TweetMedia implements BaseModel
{
    /** @use SdkModel<TweetMediaShape> */
    use SdkModel;

    /**
     * Media preview URL.
     */
    #[Required('mediaUrl')]
    public string $mediaURL;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * X media link from the tweet.
     */
    #[Required]
    public string $url;

    /**
     * X media entity ID.
     */
    #[Optional]
    public ?string $id;

    /**
     * Whether X permits direct media download.
     */
    #[Optional]
    public ?bool $allowDownload;

    /**
     * Accessibility text supplied for the media.
     */
    #[Optional]
    public ?string $altText;

    /**
     * Video aspect ratio as width and height.
     *
     * @var list<int>|null $aspectRatio
     */
    #[Optional(list: 'int')]
    public ?array $aspectRatio;

    /**
     * Media availability state reported by X.
     */
    #[Optional]
    public ?string $availabilityStatus;

    /**
     * Display-friendly media URL reported by X.
     */
    #[Optional('displayUrl')]
    public ?string $displayURL;

    /**
     * Video duration in milliseconds.
     */
    #[Optional]
    public ?int $durationMillis;

    /**
     * Expanded X media URL.
     */
    #[Optional('expandedUrl')]
    public ?string $expandedURL;

    /**
     * Face-aware crop rectangles grouped by media size.
     *
     * @var array<string,list<FaceRect>>|null $faceRects
     */
    #[Optional(map: new ListOf(FaceRect::class))]
    public ?array $faceRects;

    /**
     * Suggested image crops reported by X.
     *
     * @var list<FocusRect>|null $focusRects
     */
    #[Optional(list: FocusRect::class)]
    public ?array $focusRects;

    /**
     * Original media height.
     */
    #[Optional]
    public ?int $height;

    /**
     * Media entity offsets in the tweet text.
     *
     * @var list<int>|null $indices
     */
    #[Optional(list: 'int')]
    public ?array $indices;

    /**
     * Stable X media key.
     */
    #[Optional]
    public ?string $mediaKey;

    /**
     * Whether X reports the media as monetizable.
     */
    #[Optional]
    public ?bool $monetizable;

    /**
     * Named media renditions and resize modes.
     *
     * @var array<string,Size>|null $sizes
     */
    #[Optional(map: Size::class)]
    public ?array $sizes;

    /**
     * Available video encodings, ordered as returned.
     *
     * @var list<VideoVariant>|null $videoVariants
     */
    #[Optional(list: VideoVariant::class)]
    public ?array $videoVariants;

    /**
     * Original media width.
     */
    #[Optional]
    public ?int $width;

    /**
     * `new TweetMedia()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetMedia::with(mediaURL: ..., type: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetMedia)->withMediaURL(...)->withType(...)->withURL(...)
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
     * @param list<int>|null $aspectRatio
     * @param array<string,list<FaceRect|FaceRectShape>>|null $faceRects
     * @param list<FocusRect|FocusRectShape>|null $focusRects
     * @param list<int>|null $indices
     * @param array<string,Size|SizeShape>|null $sizes
     * @param list<VideoVariant|VideoVariantShape>|null $videoVariants
     */
    public static function with(
        string $mediaURL,
        Type|string $type,
        string $url,
        ?string $id = null,
        ?bool $allowDownload = null,
        ?string $altText = null,
        ?array $aspectRatio = null,
        ?string $availabilityStatus = null,
        ?string $displayURL = null,
        ?int $durationMillis = null,
        ?string $expandedURL = null,
        ?array $faceRects = null,
        ?array $focusRects = null,
        ?int $height = null,
        ?array $indices = null,
        ?string $mediaKey = null,
        ?bool $monetizable = null,
        ?array $sizes = null,
        ?array $videoVariants = null,
        ?int $width = null,
    ): self {
        $self = new self;

        $self['mediaURL'] = $mediaURL;
        $self['type'] = $type;
        $self['url'] = $url;

        null !== $id && $self['id'] = $id;
        null !== $allowDownload && $self['allowDownload'] = $allowDownload;
        null !== $altText && $self['altText'] = $altText;
        null !== $aspectRatio && $self['aspectRatio'] = $aspectRatio;
        null !== $availabilityStatus && $self['availabilityStatus'] = $availabilityStatus;
        null !== $displayURL && $self['displayURL'] = $displayURL;
        null !== $durationMillis && $self['durationMillis'] = $durationMillis;
        null !== $expandedURL && $self['expandedURL'] = $expandedURL;
        null !== $faceRects && $self['faceRects'] = $faceRects;
        null !== $focusRects && $self['focusRects'] = $focusRects;
        null !== $height && $self['height'] = $height;
        null !== $indices && $self['indices'] = $indices;
        null !== $mediaKey && $self['mediaKey'] = $mediaKey;
        null !== $monetizable && $self['monetizable'] = $monetizable;
        null !== $sizes && $self['sizes'] = $sizes;
        null !== $videoVariants && $self['videoVariants'] = $videoVariants;
        null !== $width && $self['width'] = $width;

        return $self;
    }

    /**
     * Media preview URL.
     */
    public function withMediaURL(string $mediaURL): self
    {
        $self = clone $this;
        $self['mediaURL'] = $mediaURL;

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
     * X media link from the tweet.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * X media entity ID.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Whether X permits direct media download.
     */
    public function withAllowDownload(bool $allowDownload): self
    {
        $self = clone $this;
        $self['allowDownload'] = $allowDownload;

        return $self;
    }

    /**
     * Accessibility text supplied for the media.
     */
    public function withAltText(string $altText): self
    {
        $self = clone $this;
        $self['altText'] = $altText;

        return $self;
    }

    /**
     * Video aspect ratio as width and height.
     *
     * @param list<int> $aspectRatio
     */
    public function withAspectRatio(array $aspectRatio): self
    {
        $self = clone $this;
        $self['aspectRatio'] = $aspectRatio;

        return $self;
    }

    /**
     * Media availability state reported by X.
     */
    public function withAvailabilityStatus(string $availabilityStatus): self
    {
        $self = clone $this;
        $self['availabilityStatus'] = $availabilityStatus;

        return $self;
    }

    /**
     * Display-friendly media URL reported by X.
     */
    public function withDisplayURL(string $displayURL): self
    {
        $self = clone $this;
        $self['displayURL'] = $displayURL;

        return $self;
    }

    /**
     * Video duration in milliseconds.
     */
    public function withDurationMillis(int $durationMillis): self
    {
        $self = clone $this;
        $self['durationMillis'] = $durationMillis;

        return $self;
    }

    /**
     * Expanded X media URL.
     */
    public function withExpandedURL(string $expandedURL): self
    {
        $self = clone $this;
        $self['expandedURL'] = $expandedURL;

        return $self;
    }

    /**
     * Face-aware crop rectangles grouped by media size.
     *
     * @param array<string,list<FaceRect|FaceRectShape>> $faceRects
     */
    public function withFaceRects(array $faceRects): self
    {
        $self = clone $this;
        $self['faceRects'] = $faceRects;

        return $self;
    }

    /**
     * Suggested image crops reported by X.
     *
     * @param list<FocusRect|FocusRectShape> $focusRects
     */
    public function withFocusRects(array $focusRects): self
    {
        $self = clone $this;
        $self['focusRects'] = $focusRects;

        return $self;
    }

    /**
     * Original media height.
     */
    public function withHeight(int $height): self
    {
        $self = clone $this;
        $self['height'] = $height;

        return $self;
    }

    /**
     * Media entity offsets in the tweet text.
     *
     * @param list<int> $indices
     */
    public function withIndices(array $indices): self
    {
        $self = clone $this;
        $self['indices'] = $indices;

        return $self;
    }

    /**
     * Stable X media key.
     */
    public function withMediaKey(string $mediaKey): self
    {
        $self = clone $this;
        $self['mediaKey'] = $mediaKey;

        return $self;
    }

    /**
     * Whether X reports the media as monetizable.
     */
    public function withMonetizable(bool $monetizable): self
    {
        $self = clone $this;
        $self['monetizable'] = $monetizable;

        return $self;
    }

    /**
     * Named media renditions and resize modes.
     *
     * @param array<string,Size|SizeShape> $sizes
     */
    public function withSizes(array $sizes): self
    {
        $self = clone $this;
        $self['sizes'] = $sizes;

        return $self;
    }

    /**
     * Available video encodings, ordered as returned.
     *
     * @param list<VideoVariant|VideoVariantShape> $videoVariants
     */
    public function withVideoVariants(array $videoVariants): self
    {
        $self = clone $this;
        $self['videoVariants'] = $videoVariants;

        return $self;
    }

    /**
     * Original media width.
     */
    public function withWidth(int $width): self
    {
        $self = clone $this;
        $self['width'] = $width;

        return $self;
    }
}
