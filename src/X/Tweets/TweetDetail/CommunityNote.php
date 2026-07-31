<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetDetail;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Community Note presentation metadata returned by X.
 *
 * @phpstan-type CommunityNoteShape = array{
 *   id?: string|null,
 *   destinationURL?: string|null,
 *   footer?: string|null,
 *   shortTitle?: string|null,
 *   subtitle?: string|null,
 *   title?: string|null,
 *   visualStyle?: string|null,
 * }
 */
final class CommunityNote implements BaseModel
{
    /** @use SdkModel<CommunityNoteShape> */
    use SdkModel;

    #[Optional]
    public ?string $id;

    #[Optional('destinationUrl')]
    public ?string $destinationURL;

    #[Optional]
    public ?string $footer;

    #[Optional]
    public ?string $shortTitle;

    #[Optional]
    public ?string $subtitle;

    #[Optional]
    public ?string $title;

    #[Optional]
    public ?string $visualStyle;

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
        ?string $id = null,
        ?string $destinationURL = null,
        ?string $footer = null,
        ?string $shortTitle = null,
        ?string $subtitle = null,
        ?string $title = null,
        ?string $visualStyle = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $destinationURL && $self['destinationURL'] = $destinationURL;
        null !== $footer && $self['footer'] = $footer;
        null !== $shortTitle && $self['shortTitle'] = $shortTitle;
        null !== $subtitle && $self['subtitle'] = $subtitle;
        null !== $title && $self['title'] = $title;
        null !== $visualStyle && $self['visualStyle'] = $visualStyle;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withDestinationURL(string $destinationURL): self
    {
        $self = clone $this;
        $self['destinationURL'] = $destinationURL;

        return $self;
    }

    public function withFooter(string $footer): self
    {
        $self = clone $this;
        $self['footer'] = $footer;

        return $self;
    }

    public function withShortTitle(string $shortTitle): self
    {
        $self = clone $this;
        $self['shortTitle'] = $shortTitle;

        return $self;
    }

    public function withSubtitle(string $subtitle): self
    {
        $self = clone $this;
        $self['subtitle'] = $subtitle;

        return $self;
    }

    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    public function withVisualStyle(string $visualStyle): self
    {
        $self = clone $this;
        $self['visualStyle'] = $visualStyle;

        return $self;
    }
}
