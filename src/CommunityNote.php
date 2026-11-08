<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\CommunityNote\PostUnavailable;
use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CommunityNoteShape = array{
 *   id: string,
 *   createdAt?: \DateTimeInterface|null,
 *   language?: string|null,
 *   classification?: string|null,
 *   text?: string|null,
 *   contributor?: CommunityNotesContributor|array<string,mixed>|null,
 *   entities?: list<CommunityNoteEntity|array<string,mixed>>|null,
 *   ratingStatus?: string|null,
 *   helpfulTags?: list<string>|null,
 *   notHelpfulTags?: list<string>|null,
 *   decidedBy?: string|null,
 *   fullyVisibleModel?: bool|null,
 *   abovePcrhThreshold?: bool|null,
 *   appealStatus?: string|null,
 *   deleted?: bool|null,
 *   tombstone?: string|null,
 *   isApiAuthor?: bool|null,
 *   isMediaNote?: bool|null,
 *   mediaNoteMatchCount?: int|null,
 *   isUrlNote?: bool|null,
 *   displayUrl?: string|null,
 *   isTranslatable?: bool|null,
 *   timeToHelpfulFromNoteMs?: int|null,
 *   timeToHelpfulFromPostMs?: int|null,
 *   impressionCount?: int|null,
 *   postID?: string|null,
 *   post?: SearchTweet2|array<string,mixed>|null,
 *   postUnavailable?: PostUnavailable|array<string,mixed>|null,
 * }
 */
final class CommunityNote implements BaseModel
{
    /** @use SdkModel<CommunityNoteShape> */
    use SdkModel;

    /**
     * Note ID.
     */
    #[Required]
    public string $id;

    /**
     * When the contributor wrote the note.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAt;

    /**
     * Language code of the note.
     */
    #[Optional]
    public ?string $language;

    /**
     * What the writer says of the post, such as MisinformedOrPotentiallyMisleading or NotMisleading.
     */
    #[Optional]
    public ?string $classification;

    /**
     * What the note says.
     */
    #[Optional]
    public ?string $text;

    /**
     * The note's writer, with the counts X sends beside a note. GET /x/community-notes/contributors/{alias} serves every count.
     */
    #[Optional]
    public ?CommunityNotesContributor $contributor;

    /**
     * Links, tags & accounts inside the text, by character range.
     *
     * @var list<CommunityNoteEntity>|null $entities
     */
    #[Optional(list: CommunityNoteEntity::class)]
    public ?array $entities;

    /**
     * X's current rating, such as NeedsMoreRatings, CurrentlyRatedHelpful or CurrentlyRatedNotHelpful. x.com shows only helpful notes under posts.
     */
    #[Optional]
    public ?string $ratingStatus;

    /**
     * Why raters called the note helpful.
     *
     * @var list<string>|null $helpfulTags
     */
    #[Optional(list: 'string')]
    public ?array $helpfulTags;

    /**
     * Why raters called the note not helpful.
     *
     * @var list<string>|null $notHelpfulTags
     */
    #[Optional(list: 'string')]
    public ?array $notHelpfulTags;

    /**
     * The X scoring model that set the rating.
     */
    #[Optional]
    public ?string $decidedBy;

    /**
     * Whether X marks that scoring model as fully visible.
     */
    #[Optional]
    public ?bool $fullyVisibleModel;

    /**
     * Whether the note scores above X's bar for a possible helpful rating.
     */
    #[Optional]
    public ?bool $abovePcrhThreshold;

    /**
     * Whether the rating is under appeal.
     */
    #[Optional]
    public ?string $appealStatus;

    /**
     * Whether the writer deleted the note.
     */
    #[Optional]
    public ?bool $deleted;

    /**
     * X's notice in place of a deleted note.
     */
    #[Optional]
    public ?string $tombstone;

    /**
     * Whether the note came through X's API.
     */
    #[Optional]
    public ?bool $isApiAuthor;

    /**
     * Whether the note is about the post's media. X can show such a note on other posts.
     */
    #[Optional]
    public ?bool $isMediaNote;

    /**
     * Other posts X matched a media note to.
     */
    #[Optional]
    public ?int $mediaNoteMatchCount;

    /**
     * Whether the note is on a link.
     */
    #[Optional]
    public ?bool $isUrlNote;

    /**
     * The link a link note is on, as X shows it.
     */
    #[Optional]
    public ?string $displayUrl;

    /**
     * Whether X offers a translation of the note.
     */
    #[Optional]
    public ?bool $isTranslatable;

    /**
     * Milliseconds from the note's creation to its helpful rating.
     */
    #[Optional]
    public ?int $timeToHelpfulFromNoteMs;

    /**
     * Milliseconds from the post's creation to the note's helpful rating.
     */
    #[Optional]
    public ?int $timeToHelpfulFromPostMs;

    /**
     * Views of the note, when X shares them.
     */
    #[Optional]
    public ?int $impressionCount;

    /**
     * ID of the post the note is on.
     */
    #[Optional('postId')]
    public ?string $postID;

    /**
     * The post the note is on. Null when X no longer shows it.
     */
    #[Optional(nullable: true)]
    public ?SearchTweet2 $post;

    /**
     * Why X shows no post, when X says.
     */
    #[Optional]
    public ?PostUnavailable $postUnavailable;

    /**
     * `new CommunityNote()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CommunityNote::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CommunityNote)->withId(...)
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
     * @param CommunityNotesContributor|array<string,mixed>|null $contributor
     * @param list<CommunityNoteEntity|array<string,mixed>>|null $entities
     * @param list<string>|null $helpfulTags
     * @param list<string>|null $notHelpfulTags
     * @param SearchTweet2|array<string,mixed>|null $post
     * @param PostUnavailable|array<string,mixed>|null $postUnavailable
     */
    public static function with(string $id, ?\DateTimeInterface $createdAt = null, ?string $language = null, ?string $classification = null, ?string $text = null, CommunityNotesContributor|array|null $contributor = null, ?array $entities = null, ?string $ratingStatus = null, ?array $helpfulTags = null, ?array $notHelpfulTags = null, ?string $decidedBy = null, ?bool $fullyVisibleModel = null, ?bool $abovePcrhThreshold = null, ?string $appealStatus = null, ?bool $deleted = null, ?string $tombstone = null, ?bool $isApiAuthor = null, ?bool $isMediaNote = null, ?int $mediaNoteMatchCount = null, ?bool $isUrlNote = null, ?string $displayUrl = null, ?bool $isTranslatable = null, ?int $timeToHelpfulFromNoteMs = null, ?int $timeToHelpfulFromPostMs = null, ?int $impressionCount = null, ?string $postID = null, SearchTweet2|array|null $post = null, PostUnavailable|array|null $postUnavailable = null): self
    {
        $self = new self;

        $self['id'] = $id;

        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $language && $self['language'] = $language;
        null !== $classification && $self['classification'] = $classification;
        null !== $text && $self['text'] = $text;
        null !== $contributor && $self['contributor'] = $contributor;
        null !== $entities && $self['entities'] = $entities;
        null !== $ratingStatus && $self['ratingStatus'] = $ratingStatus;
        null !== $helpfulTags && $self['helpfulTags'] = $helpfulTags;
        null !== $notHelpfulTags && $self['notHelpfulTags'] = $notHelpfulTags;
        null !== $decidedBy && $self['decidedBy'] = $decidedBy;
        null !== $fullyVisibleModel && $self['fullyVisibleModel'] = $fullyVisibleModel;
        null !== $abovePcrhThreshold && $self['abovePcrhThreshold'] = $abovePcrhThreshold;
        null !== $appealStatus && $self['appealStatus'] = $appealStatus;
        null !== $deleted && $self['deleted'] = $deleted;
        null !== $tombstone && $self['tombstone'] = $tombstone;
        null !== $isApiAuthor && $self['isApiAuthor'] = $isApiAuthor;
        null !== $isMediaNote && $self['isMediaNote'] = $isMediaNote;
        null !== $mediaNoteMatchCount && $self['mediaNoteMatchCount'] = $mediaNoteMatchCount;
        null !== $isUrlNote && $self['isUrlNote'] = $isUrlNote;
        null !== $displayUrl && $self['displayUrl'] = $displayUrl;
        null !== $isTranslatable && $self['isTranslatable'] = $isTranslatable;
        null !== $timeToHelpfulFromNoteMs && $self['timeToHelpfulFromNoteMs'] = $timeToHelpfulFromNoteMs;
        null !== $timeToHelpfulFromPostMs && $self['timeToHelpfulFromPostMs'] = $timeToHelpfulFromPostMs;
        null !== $impressionCount && $self['impressionCount'] = $impressionCount;
        null !== $postID && $self['postID'] = $postID;
        null !== $post && $self['post'] = $post;
        null !== $postUnavailable && $self['postUnavailable'] = $postUnavailable;

        return $self;
    }

    /**
     * Note ID.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * When the contributor wrote the note.
     */
    public function withCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Language code of the note.
     */
    public function withLanguage(?string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * What the writer says of the post, such as MisinformedOrPotentiallyMisleading or NotMisleading.
     */
    public function withClassification(?string $classification): self
    {
        $self = clone $this;
        $self['classification'] = $classification;

        return $self;
    }

    /**
     * What the note says.
     */
    public function withText(?string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * The note's writer, with the counts X sends beside a note. GET /x/community-notes/contributors/{alias} serves every count.
     *
     * @param CommunityNotesContributor|array<string,mixed>|null $contributor
     */
    public function withContributor(CommunityNotesContributor|array|null $contributor): self
    {
        $self = clone $this;
        $self['contributor'] = $contributor;

        return $self;
    }

    /**
     * Links, tags & accounts inside the text, by character range.
     *
     * @param list<CommunityNoteEntity|array<string,mixed>>|null $entities
     */
    public function withEntities(?array $entities): self
    {
        $self = clone $this;
        $self['entities'] = $entities;

        return $self;
    }

    /**
     * X's current rating, such as NeedsMoreRatings, CurrentlyRatedHelpful or CurrentlyRatedNotHelpful. x.com shows only helpful notes under posts.
     */
    public function withRatingStatus(?string $ratingStatus): self
    {
        $self = clone $this;
        $self['ratingStatus'] = $ratingStatus;

        return $self;
    }

    /**
     * Why raters called the note helpful.
     *
     * @param list<string>|null $helpfulTags
     */
    public function withHelpfulTags(?array $helpfulTags): self
    {
        $self = clone $this;
        $self['helpfulTags'] = $helpfulTags;

        return $self;
    }

    /**
     * Why raters called the note not helpful.
     *
     * @param list<string>|null $notHelpfulTags
     */
    public function withNotHelpfulTags(?array $notHelpfulTags): self
    {
        $self = clone $this;
        $self['notHelpfulTags'] = $notHelpfulTags;

        return $self;
    }

    /**
     * The X scoring model that set the rating.
     */
    public function withDecidedBy(?string $decidedBy): self
    {
        $self = clone $this;
        $self['decidedBy'] = $decidedBy;

        return $self;
    }

    /**
     * Whether X marks that scoring model as fully visible.
     */
    public function withFullyVisibleModel(?bool $fullyVisibleModel): self
    {
        $self = clone $this;
        $self['fullyVisibleModel'] = $fullyVisibleModel;

        return $self;
    }

    /**
     * Whether the note scores above X's bar for a possible helpful rating.
     */
    public function withAbovePcrhThreshold(?bool $abovePcrhThreshold): self
    {
        $self = clone $this;
        $self['abovePcrhThreshold'] = $abovePcrhThreshold;

        return $self;
    }

    /**
     * Whether the rating is under appeal.
     */
    public function withAppealStatus(?string $appealStatus): self
    {
        $self = clone $this;
        $self['appealStatus'] = $appealStatus;

        return $self;
    }

    /**
     * Whether the writer deleted the note.
     */
    public function withDeleted(?bool $deleted): self
    {
        $self = clone $this;
        $self['deleted'] = $deleted;

        return $self;
    }

    /**
     * X's notice in place of a deleted note.
     */
    public function withTombstone(?string $tombstone): self
    {
        $self = clone $this;
        $self['tombstone'] = $tombstone;

        return $self;
    }

    /**
     * Whether the note came through X's API.
     */
    public function withIsApiAuthor(?bool $isApiAuthor): self
    {
        $self = clone $this;
        $self['isApiAuthor'] = $isApiAuthor;

        return $self;
    }

    /**
     * Whether the note is about the post's media. X can show such a note on other posts.
     */
    public function withIsMediaNote(?bool $isMediaNote): self
    {
        $self = clone $this;
        $self['isMediaNote'] = $isMediaNote;

        return $self;
    }

    /**
     * Other posts X matched a media note to.
     */
    public function withMediaNoteMatchCount(?int $mediaNoteMatchCount): self
    {
        $self = clone $this;
        $self['mediaNoteMatchCount'] = $mediaNoteMatchCount;

        return $self;
    }

    /**
     * Whether the note is on a link.
     */
    public function withIsUrlNote(?bool $isUrlNote): self
    {
        $self = clone $this;
        $self['isUrlNote'] = $isUrlNote;

        return $self;
    }

    /**
     * The link a link note is on, as X shows it.
     */
    public function withDisplayUrl(?string $displayUrl): self
    {
        $self = clone $this;
        $self['displayUrl'] = $displayUrl;

        return $self;
    }

    /**
     * Whether X offers a translation of the note.
     */
    public function withIsTranslatable(?bool $isTranslatable): self
    {
        $self = clone $this;
        $self['isTranslatable'] = $isTranslatable;

        return $self;
    }

    /**
     * Milliseconds from the note's creation to its helpful rating.
     */
    public function withTimeToHelpfulFromNoteMs(?int $timeToHelpfulFromNoteMs): self
    {
        $self = clone $this;
        $self['timeToHelpfulFromNoteMs'] = $timeToHelpfulFromNoteMs;

        return $self;
    }

    /**
     * Milliseconds from the post's creation to the note's helpful rating.
     */
    public function withTimeToHelpfulFromPostMs(?int $timeToHelpfulFromPostMs): self
    {
        $self = clone $this;
        $self['timeToHelpfulFromPostMs'] = $timeToHelpfulFromPostMs;

        return $self;
    }

    /**
     * Views of the note, when X shares them.
     */
    public function withImpressionCount(?int $impressionCount): self
    {
        $self = clone $this;
        $self['impressionCount'] = $impressionCount;

        return $self;
    }

    /**
     * ID of the post the note is on.
     */
    public function withPostID(?string $postID): self
    {
        $self = clone $this;
        $self['postID'] = $postID;

        return $self;
    }

    /**
     * The post the note is on. Null when X no longer shows it.
     *
     * @param SearchTweet2|array<string,mixed>|null $post
     */
    public function withPost(SearchTweet2|array|null $post): self
    {
        $self = clone $this;
        $self['post'] = $post;

        return $self;
    }

    /**
     * Why X shows no post, when X says.
     *
     * @param PostUnavailable|array<string,mixed>|null $postUnavailable
     */
    public function withPostUnavailable(PostUnavailable|array|null $postUnavailable): self
    {
        $self = clone $this;
        $self['postUnavailable'] = $postUnavailable;

        return $self;
    }
}
