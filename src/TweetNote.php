<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\TweetNote\InlineMedia;
use XTwitterScraper\TweetNote\RichtextTags;

/**
 * @phpstan-type TweetNoteShape = array{
 *   text: string,
 *   id?: string|null,
 *   noteID?: string|null,
 *   isExpandable?: bool|null,
 *   entities?: TweetEntities|array<string,mixed>|null,
 *   inlineMedia?: list<InlineMedia|array<string,mixed>>|null,
 *   richtextTags?: list<RichtextTags|array<string,mixed>>|null,
 * }
 */
final class TweetNote implements BaseModel
{
    /** @use SdkModel<TweetNoteShape> */
    use SdkModel;

    #[Required]
    public string $text;

    /**
     * X's global ID of the Note, base64 of `NoteTweet:<noteId>`.
     */
    #[Optional]
    public ?string $id;

    /**
     * The Note's own ID, apart from the post's.
     */
    #[Optional('noteId')]
    public ?string $noteID;

    #[Optional]
    public ?bool $isExpandable;

    /**
     * Lists hashtags, symbols, links, and mentions from tweet text.
     */
    #[Optional]
    public ?TweetEntities $entities;

    /**
     * Inline media positions in the Note Tweet text.
     *
     * @var list<InlineMedia>|null $inlineMedia
     */
    #[Optional(list: InlineMedia::class)]
    public ?array $inlineMedia;

    /**
     * @var list<RichtextTags>|null $richtextTags
     */
    #[Optional(list: RichtextTags::class)]
    public ?array $richtextTags;

    /**
     * `new TweetNote()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetNote::with(text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetNote)->withText(...)
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
     * @param TweetEntities|array<string,mixed>|null $entities
     * @param list<InlineMedia|array<string,mixed>>|null $inlineMedia
     * @param list<RichtextTags|array<string,mixed>>|null $richtextTags
     */
    public static function with(string $text, ?string $id = null, ?string $noteID = null, ?bool $isExpandable = null, TweetEntities|array|null $entities = null, ?array $inlineMedia = null, ?array $richtextTags = null): self
    {
        $self = new self;

        $self['text'] = $text;

        null !== $id && $self['id'] = $id;
        null !== $noteID && $self['noteID'] = $noteID;
        null !== $isExpandable && $self['isExpandable'] = $isExpandable;
        null !== $entities && $self['entities'] = $entities;
        null !== $inlineMedia && $self['inlineMedia'] = $inlineMedia;
        null !== $richtextTags && $self['richtextTags'] = $richtextTags;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * X's global ID of the Note, base64 of `NoteTweet:<noteId>`.
     */
    public function withId(?string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The Note's own ID, apart from the post's.
     */
    public function withNoteID(?string $noteID): self
    {
        $self = clone $this;
        $self['noteID'] = $noteID;

        return $self;
    }

    public function withIsExpandable(?bool $isExpandable): self
    {
        $self = clone $this;
        $self['isExpandable'] = $isExpandable;

        return $self;
    }

    /**
     * Lists hashtags, symbols, links, and mentions from tweet text.
     *
     * @param TweetEntities|array<string,mixed>|null $entities
     */
    public function withEntities(TweetEntities|array|null $entities): self
    {
        $self = clone $this;
        $self['entities'] = $entities;

        return $self;
    }

    /**
     * Inline media positions in the Note Tweet text.
     *
     * @param list<InlineMedia|array<string,mixed>>|null $inlineMedia
     */
    public function withInlineMedia(?array $inlineMedia): self
    {
        $self = clone $this;
        $self['inlineMedia'] = $inlineMedia;

        return $self;
    }

    /**
     * @param list<RichtextTags|array<string,mixed>>|null $richtextTags
     */
    public function withRichtextTags(?array $richtextTags): self
    {
        $self = clone $this;
        $self['richtextTags'] = $richtextTags;

        return $self;
    }
}
