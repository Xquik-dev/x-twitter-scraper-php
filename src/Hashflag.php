<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Hashflag\Animations;

/**
 * @phpstan-type HashflagShape = array{
 *   hashtag: string,
 *   assetUrl: string,
 *   startsAt: \DateTimeInterface,
 *   endsAt: \DateTimeInterface,
 *   isHashfettiEnabled: bool,
 *   animations: list<Animations|array<string,mixed>>,
 * }
 */
final class Hashflag implements BaseModel
{
    /** @use SdkModel<HashflagShape> */
    use SdkModel;

    /**
     * Hashtag text without the hash sign. X also lists some plain phrases.
     */
    #[Required]
    public string $hashtag;

    /**
     * Image of the emoji.
     */
    #[Required]
    public string $assetUrl;

    /**
     * When X starts showing the emoji, in UTC.
     */
    #[Required]
    public \DateTimeInterface $startsAt;

    /**
     * When X stops showing the emoji, in UTC.
     */
    #[Required]
    public \DateTimeInterface $endsAt;

    /**
     * Whether X marks the hashflag for its hashfetti effect.
     */
    #[Required]
    public bool $isHashfettiEnabled;

    /**
     * Animations X plays for the hashtag, such as on a like. Often empty.
     *
     * @var list<Animations> $animations
     */
    #[Required(list: Animations::class)]
    public array $animations;

    /**
     * `new Hashflag()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Hashflag::with(hashtag: ..., assetUrl: ..., startsAt: ..., endsAt: ..., isHashfettiEnabled: ..., animations: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Hashflag)->withHashtag(...)->withAssetUrl(...)->withStartsAt(...)->withEndsAt(...)->withIsHashfettiEnabled(...)->withAnimations(...)
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
     * @param list<Animations|array<string,mixed>> $animations
     */
    public static function with(string $hashtag, string $assetUrl, \DateTimeInterface $startsAt, \DateTimeInterface $endsAt, bool $isHashfettiEnabled, array $animations): self
    {
        $self = new self;

        $self['hashtag'] = $hashtag;
        $self['assetUrl'] = $assetUrl;
        $self['startsAt'] = $startsAt;
        $self['endsAt'] = $endsAt;
        $self['isHashfettiEnabled'] = $isHashfettiEnabled;
        $self['animations'] = $animations;

        return $self;
    }

    /**
     * Hashtag text without the hash sign. X also lists some plain phrases.
     */
    public function withHashtag(string $hashtag): self
    {
        $self = clone $this;
        $self['hashtag'] = $hashtag;

        return $self;
    }

    /**
     * Image of the emoji.
     */
    public function withAssetUrl(string $assetUrl): self
    {
        $self = clone $this;
        $self['assetUrl'] = $assetUrl;

        return $self;
    }

    /**
     * When X starts showing the emoji, in UTC.
     */
    public function withStartsAt(\DateTimeInterface $startsAt): self
    {
        $self = clone $this;
        $self['startsAt'] = $startsAt;

        return $self;
    }

    /**
     * When X stops showing the emoji, in UTC.
     */
    public function withEndsAt(\DateTimeInterface $endsAt): self
    {
        $self = clone $this;
        $self['endsAt'] = $endsAt;

        return $self;
    }

    /**
     * Whether X marks the hashflag for its hashfetti effect.
     */
    public function withIsHashfettiEnabled(bool $isHashfettiEnabled): self
    {
        $self = clone $this;
        $self['isHashfettiEnabled'] = $isHashfettiEnabled;

        return $self;
    }

    /**
     * Animations X plays for the hashtag, such as on a like. Often empty.
     *
     * @param list<Animations|array<string,mixed>> $animations
     */
    public function withAnimations(array $animations): self
    {
        $self = clone $this;
        $self['animations'] = $animations;

        return $self;
    }
}
