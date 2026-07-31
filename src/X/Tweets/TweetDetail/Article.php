<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetDetail;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Article metadata attached to a tweet.
 *
 * @phpstan-type ArticleShape = array{
 *   id?: string|null,
 *   coverMediaURL?: string|null,
 *   previewText?: string|null,
 *   title?: string|null,
 * }
 */
final class Article implements BaseModel
{
    /** @use SdkModel<ArticleShape> */
    use SdkModel;

    #[Optional]
    public ?string $id;

    #[Optional('coverMediaUrl')]
    public ?string $coverMediaURL;

    #[Optional]
    public ?string $previewText;

    #[Optional]
    public ?string $title;

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
        ?string $coverMediaURL = null,
        ?string $previewText = null,
        ?string $title = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $coverMediaURL && $self['coverMediaURL'] = $coverMediaURL;
        null !== $previewText && $self['previewText'] = $previewText;
        null !== $title && $self['title'] = $title;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCoverMediaURL(string $coverMediaURL): self
    {
        $self = clone $this;
        $self['coverMediaURL'] = $coverMediaURL;

        return $self;
    }

    public function withPreviewText(string $previewText): self
    {
        $self = clone $this;
        $self['previewText'] = $previewText;

        return $self;
    }

    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }
}
