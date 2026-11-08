<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\XGetTrendsHistoryResponse\Snapshots;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TrendsShape = array{
 *   name: string,
 *   description?: string|null,
 *   query?: string|null,
 *   promotedContent?: string|null,
 *   rank?: int|null,
 *   tweetVolume?: int|null,
 *   url?: string|null,
 * }
 */
final class Trends implements BaseModel
{
    /** @use SdkModel<TrendsShape> */
    use SdkModel;

    #[Required]
    public string $name;

    #[Optional]
    public ?string $description;

    #[Optional]
    public ?string $query;

    /**
     * X's promotion ID of a promoted trend. Null for the others.
     */
    #[Optional(nullable: true)]
    public ?string $promotedContent;

    /**
     * The trend's place in X's list at that time.
     */
    #[Optional]
    public ?int $rank;

    /**
     * X's post count for the trend at that time, when X showed one.
     */
    #[Optional(nullable: true)]
    public ?int $tweetVolume;

    /**
     * The trend's search link on X.
     */
    #[Optional]
    public ?string $url;

    /**
     * `new Trends()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Trends::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Trends)->withName(...)
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
    public static function with(string $name, ?string $description = null, ?string $query = null, ?string $promotedContent = null, ?int $rank = null, ?int $tweetVolume = null, ?string $url = null): self
    {
        $self = new self;

        $self['name'] = $name;

        null !== $description && $self['description'] = $description;
        null !== $query && $self['query'] = $query;
        null !== $promotedContent && $self['promotedContent'] = $promotedContent;
        null !== $rank && $self['rank'] = $rank;
        null !== $tweetVolume && $self['tweetVolume'] = $tweetVolume;
        null !== $url && $self['url'] = $url;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withQuery(?string $query): self
    {
        $self = clone $this;
        $self['query'] = $query;

        return $self;
    }

    /**
     * X's promotion ID of a promoted trend. Null for the others.
     */
    public function withPromotedContent(?string $promotedContent): self
    {
        $self = clone $this;
        $self['promotedContent'] = $promotedContent;

        return $self;
    }

    /**
     * The trend's place in X's list at that time.
     */
    public function withRank(?int $rank): self
    {
        $self = clone $this;
        $self['rank'] = $rank;

        return $self;
    }

    /**
     * X's post count for the trend at that time, when X showed one.
     */
    public function withTweetVolume(?int $tweetVolume): self
    {
        $self = clone $this;
        $self['tweetVolume'] = $tweetVolume;

        return $self;
    }

    /**
     * The trend's search link on X.
     */
    public function withUrl(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
