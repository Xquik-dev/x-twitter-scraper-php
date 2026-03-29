<?php

declare(strict_types=1);

namespace XTwitterScraper\X\XGetArticleResponse\Article;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ContentShape = array{
 *   height?: int|null,
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

    #[Optional]
    public ?string $text;

    /**
     * Block type: unstyled, header-one, header-two, header-three, unordered-list-item, ordered-list-item, image, gif, divider.
     */
    #[Optional]
    public ?string $type;

    /**
     * Media URL for image/gif blocks.
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
     */
    public static function with(
        ?int $height = null,
        ?string $text = null,
        ?string $type = null,
        ?string $url = null,
        ?int $width = null,
    ): self {
        $self = new self;

        null !== $height && $self['height'] = $height;
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

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * Block type: unstyled, header-one, header-two, header-three, unordered-list-item, ordered-list-item, image, gif, divider.
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Media URL for image/gif blocks.
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
