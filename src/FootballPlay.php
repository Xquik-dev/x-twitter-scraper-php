<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\FootballPlay\OnField;
use XTwitterScraper\FootballPlay\Post;
use XTwitterScraper\FootballPlay\Score;
use XTwitterScraper\FootballPlay\Start;

/**
 * @phpstan-type FootballPlayShape = array{
 *   id: string|null,
 *   sequence: int|null,
 *   clock: string|null,
 *   type: string|null,
 *   direction: string|null,
 *   description: string|null,
 *   scoring: bool|null,
 *   homePoints: int|null,
 *   awayPoints: int|null,
 *   score: Score|array<string,mixed>|null,
 *   start: Start|array<string,mixed>|null,
 *   onField: OnField|array<string,mixed>|null,
 *   details: list<FootballPlayDetail|array<string,mixed>>,
 *   post: Post|array<string,mixed>|null,
 *   videoPostID: string|null,
 *   videoReplyPostID: string|null,
 * }
 */
final class FootballPlay implements BaseModel
{
    /** @use SdkModel<FootballPlayShape> */
    use SdkModel;

    /**
     * X's ID for the play within the game.
     */
    #[Required]
    public ?string $id;

    /**
     * The play's place in its drive, or null when X sends no digits.
     */
    #[Required]
    public ?int $sequence;

    /**
     * The game clock when the play started, as HH:MM:SS.
     */
    #[Required]
    public ?string $clock;

    /**
     * X's kind of play, such as Pass, Rush, Punt or Conversion.
     */
    #[Required]
    public ?string $type;

    /**
     * Where the play went, such as Left or Middle.
     */
    #[Required]
    public ?string $direction;

    /**
     * The play as the official play-by-play writes it.
     */
    #[Required]
    public ?string $description;

    /**
     * Whether the play scored points.
     */
    #[Required]
    public ?bool $scoring;

    /**
     * The home team's points after the play.
     */
    #[Required]
    public ?int $homePoints;

    /**
     * The away team's points after the play.
     */
    #[Required]
    public ?int $awayPoints;

    /**
     * The points a scoring play added, or null.
     */
    #[Required]
    public ?Score $score;

    /**
     * Down & distance when the play started, or null.
     */
    #[Required]
    public ?Start $start;

    /**
     * Flags X shows on the field for the play, or null.
     */
    #[Required]
    public ?OnField $onField;

    /**
     * The play's steps, in order.
     *
     * @var list<FootballPlayDetail> $details
     */
    #[Required(list: FootballPlayDetail::class)]
    public array $details;

    /**
     * The post X links to the play, or null.
     */
    #[Required]
    public ?Post $post;

    /**
     * The ID of a post with the play's video.
     */
    #[Required('videoPostId')]
    public ?string $videoPostID;

    /**
     * The ID of a reply with the play's video.
     */
    #[Required('videoReplyPostId')]
    public ?string $videoReplyPostID;

    /**
     * `new FootballPlay()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballPlay::with(id: ..., sequence: ..., clock: ..., type: ..., direction: ..., description: ..., scoring: ..., homePoints: ..., awayPoints: ..., score: ..., start: ..., onField: ..., details: ..., post: ..., videoPostID: ..., videoReplyPostID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballPlay)->withId(...)->withSequence(...)->withClock(...)->withType(...)->withDirection(...)->withDescription(...)->withScoring(...)->withHomePoints(...)->withAwayPoints(...)->withScore(...)->withStart(...)->withOnField(...)->withDetails(...)->withPost(...)->withVideoPostID(...)->withVideoReplyPostID(...)
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
     * @param Score|array<string,mixed>|null $score
     * @param Start|array<string,mixed>|null $start
     * @param OnField|array<string,mixed>|null $onField
     * @param list<FootballPlayDetail|array<string,mixed>> $details
     * @param Post|array<string,mixed>|null $post
     */
    public static function with(?string $id, ?int $sequence, ?string $clock, ?string $type, ?string $direction, ?string $description, ?bool $scoring, ?int $homePoints, ?int $awayPoints, Score|array|null $score, Start|array|null $start, OnField|array|null $onField, array $details, Post|array|null $post, ?string $videoPostID, ?string $videoReplyPostID): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['sequence'] = $sequence;
        $self['clock'] = $clock;
        $self['type'] = $type;
        $self['direction'] = $direction;
        $self['description'] = $description;
        $self['scoring'] = $scoring;
        $self['homePoints'] = $homePoints;
        $self['awayPoints'] = $awayPoints;
        $self['score'] = $score;
        $self['start'] = $start;
        $self['onField'] = $onField;
        $self['details'] = $details;
        $self['post'] = $post;
        $self['videoPostID'] = $videoPostID;
        $self['videoReplyPostID'] = $videoReplyPostID;

        return $self;
    }

    /**
     * X's ID for the play within the game.
     */
    public function withId(?string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The play's place in its drive, or null when X sends no digits.
     */
    public function withSequence(?int $sequence): self
    {
        $self = clone $this;
        $self['sequence'] = $sequence;

        return $self;
    }

    /**
     * The game clock when the play started, as HH:MM:SS.
     */
    public function withClock(?string $clock): self
    {
        $self = clone $this;
        $self['clock'] = $clock;

        return $self;
    }

    /**
     * X's kind of play, such as Pass, Rush, Punt or Conversion.
     */
    public function withType(?string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Where the play went, such as Left or Middle.
     */
    public function withDirection(?string $direction): self
    {
        $self = clone $this;
        $self['direction'] = $direction;

        return $self;
    }

    /**
     * The play as the official play-by-play writes it.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Whether the play scored points.
     */
    public function withScoring(?bool $scoring): self
    {
        $self = clone $this;
        $self['scoring'] = $scoring;

        return $self;
    }

    /**
     * The home team's points after the play.
     */
    public function withHomePoints(?int $homePoints): self
    {
        $self = clone $this;
        $self['homePoints'] = $homePoints;

        return $self;
    }

    /**
     * The away team's points after the play.
     */
    public function withAwayPoints(?int $awayPoints): self
    {
        $self = clone $this;
        $self['awayPoints'] = $awayPoints;

        return $self;
    }

    /**
     * The points a scoring play added, or null.
     *
     * @param Score|array<string,mixed>|null $score
     */
    public function withScore(Score|array|null $score): self
    {
        $self = clone $this;
        $self['score'] = $score;

        return $self;
    }

    /**
     * Down & distance when the play started, or null.
     *
     * @param Start|array<string,mixed>|null $start
     */
    public function withStart(Start|array|null $start): self
    {
        $self = clone $this;
        $self['start'] = $start;

        return $self;
    }

    /**
     * Flags X shows on the field for the play, or null.
     *
     * @param OnField|array<string,mixed>|null $onField
     */
    public function withOnField(OnField|array|null $onField): self
    {
        $self = clone $this;
        $self['onField'] = $onField;

        return $self;
    }

    /**
     * The play's steps, in order.
     *
     * @param list<FootballPlayDetail|array<string,mixed>> $details
     */
    public function withDetails(array $details): self
    {
        $self = clone $this;
        $self['details'] = $details;

        return $self;
    }

    /**
     * The post X links to the play, or null.
     *
     * @param Post|array<string,mixed>|null $post
     */
    public function withPost(Post|array|null $post): self
    {
        $self = clone $this;
        $self['post'] = $post;

        return $self;
    }

    /**
     * The ID of a post with the play's video.
     */
    public function withVideoPostID(?string $videoPostID): self
    {
        $self = clone $this;
        $self['videoPostID'] = $videoPostID;

        return $self;
    }

    /**
     * The ID of a reply with the play's video.
     */
    public function withVideoReplyPostID(?string $videoReplyPostID): self
    {
        $self = clone $this;
        $self['videoReplyPostID'] = $videoReplyPostID;

        return $self;
    }
}
