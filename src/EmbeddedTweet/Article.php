<?php

declare(strict_types=1);

namespace XTwitterScraper\EmbeddedTweet;

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
 *   coverMedia?: array<string,mixed>|null,
 *   lifecycleState?: array<string,mixed>|null,
 *   metadata?: array<string,mixed>|null,
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

    /**
     * Public metadata whose fields X defines.
     *
     * @var array<string,mixed>|null $coverMedia
     */
    #[Optional(map: 'mixed')]
    public ?array $coverMedia;

    /**
     * Public metadata whose fields X defines.
     *
     * @var array<string,mixed>|null $lifecycleState
     */
    #[Optional(map: 'mixed')]
    public ?array $lifecycleState;

    /**
     * Public metadata whose fields X defines.
     *
     * @var array<string,mixed>|null $metadata
     */
    #[Optional(map: 'mixed')]
    public ?array $metadata;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,mixed>|null $coverMedia
     * @param array<string,mixed>|null $lifecycleState
     * @param array<string,mixed>|null $metadata
     */
    public static function with(
        ?string $id = null,
        ?string $coverMediaURL = null,
        ?string $previewText = null,
        ?string $title = null,
        ?array $coverMedia = null,
        ?array $lifecycleState = null,
        ?array $metadata = null
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $coverMediaURL && $self['coverMediaURL'] = $coverMediaURL;
        null !== $previewText && $self['previewText'] = $previewText;
        null !== $title && $self['title'] = $title;

        null !== $coverMedia && $self['coverMedia'] = $coverMedia;

        null !== $lifecycleState && $self['lifecycleState'] = $lifecycleState;

        null !== $metadata && $self['metadata'] = $metadata;

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

    /**
     * Public metadata whose fields X defines.
     *
     * @param array<string,mixed>|null $coverMedia
     */
    public function withCoverMedia(?array $coverMedia): self
    {
        $self = clone $this;
        $self['coverMedia'] = $coverMedia;

        return $self;
    }

    /**
     * Public metadata whose fields X defines.
     *
     * @param array<string,mixed>|null $lifecycleState
     */
    public function withLifecycleState(?array $lifecycleState): self
    {
        $self = clone $this;
        $self['lifecycleState'] = $lifecycleState;

        return $self;
    }

    /**
     * Public metadata whose fields X defines.
     *
     * @param array<string,mixed>|null $metadata
     */
    public function withMetadata(?array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }
}
