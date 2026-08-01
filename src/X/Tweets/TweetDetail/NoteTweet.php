<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetDetail;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Tweets\TweetDetail\NoteTweet\RichtextTag;

/**
 * Complete Note Tweet content and rich-text metadata.
 *
 * @phpstan-import-type RichtextTagShape from \XTwitterScraper\X\Tweets\TweetDetail\NoteTweet\RichtextTag
 *
 * @phpstan-type NoteTweetShape = array{
 *   text: string,
 *   id?: string|null,
 *   entities?: array<string,mixed>|null,
 *   isExpandable?: bool|null,
 *   richtextTags?: list<RichtextTag|RichtextTagShape>|null,
 * }
 */
final class NoteTweet implements BaseModel
{
    /** @use SdkModel<NoteTweetShape> */
    use SdkModel;

    #[Required]
    public string $text;

    #[Optional]
    public ?string $id;

    /** @var array<string,mixed>|null $entities */
    #[Optional(map: 'mixed')]
    public ?array $entities;

    #[Optional]
    public ?bool $isExpandable;

    /** @var list<RichtextTag>|null $richtextTags */
    #[Optional(list: RichtextTag::class)]
    public ?array $richtextTags;

    /**
     * `new NoteTweet()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * NoteTweet::with(text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new NoteTweet)->withText(...)
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
     * @param array<string,mixed>|null $entities
     * @param list<RichtextTag|RichtextTagShape>|null $richtextTags
     */
    public static function with(
        string $text,
        ?string $id = null,
        ?array $entities = null,
        ?bool $isExpandable = null,
        ?array $richtextTags = null,
    ): self {
        $self = new self;

        $self['text'] = $text;

        null !== $id && $self['id'] = $id;
        null !== $entities && $self['entities'] = $entities;
        null !== $isExpandable && $self['isExpandable'] = $isExpandable;
        null !== $richtextTags && $self['richtextTags'] = $richtextTags;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param array<string,mixed> $entities
     */
    public function withEntities(array $entities): self
    {
        $self = clone $this;
        $self['entities'] = $entities;

        return $self;
    }

    public function withIsExpandable(bool $isExpandable): self
    {
        $self = clone $this;
        $self['isExpandable'] = $isExpandable;

        return $self;
    }

    /**
     * @param list<RichtextTag|RichtextTagShape> $richtextTags
     */
    public function withRichtextTags(array $richtextTags): self
    {
        $self = clone $this;
        $self['richtextTags'] = $richtextTags;

        return $self;
    }
}
