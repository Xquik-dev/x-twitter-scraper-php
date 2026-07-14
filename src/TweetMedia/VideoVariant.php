<?php

declare(strict_types=1);

namespace XTwitterScraper\TweetMedia;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type VideoVariantShape = array{
 *   contentType: string, url: string, bitrate?: int|null
 * }
 */
final class VideoVariant implements BaseModel
{
    /** @use SdkModel<VideoVariantShape> */
    use SdkModel;

    #[Required]
    public string $contentType;

    #[Required]
    public string $url;

    #[Optional]
    public ?int $bitrate;

    /**
     * `new VideoVariant()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * VideoVariant::with(contentType: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new VideoVariant)->withContentType(...)->withURL(...)
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
     */
    public static function with(
        string $contentType,
        string $url,
        ?int $bitrate = null
    ): self {
        $self = new self;

        $self['contentType'] = $contentType;
        $self['url'] = $url;

        null !== $bitrate && $self['bitrate'] = $bitrate;

        return $self;
    }

    public function withContentType(string $contentType): self
    {
        $self = clone $this;
        $self['contentType'] = $contentType;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    public function withBitrate(int $bitrate): self
    {
        $self = clone $this;
        $self['bitrate'] = $bitrate;

        return $self;
    }
}
