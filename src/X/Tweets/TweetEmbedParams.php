<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Tweets\TweetEmbedParams\Theme;

/**
 * Returns the HTML that X gives websites to embed 1 public tweet, with the tweet's link and author.
 *
 * @see XTwitterScraper\Services\X\TweetsService::embed()
 *
 * @phpstan-type TweetEmbedParamsShape = array{
 *   theme?: Theme|value-of<Theme>|null,
 *   hideMedia?: bool|null,
 *   hideThread?: bool|null,
 *   omitScript?: bool|null,
 *   fields?: string|null,
 *   omit?: string|null,
 * }
 */
final class TweetEmbedParams implements BaseModel
{
    /** @use SdkModel<TweetEmbedParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Color theme of the embed. X uses light when left out.
     *
     * @var value-of<Theme>|null $theme
     */
    #[Optional(enum: Theme::class)]
    public ?string $theme;

    /**
     * Set `true` to leave photos, videos, and link cards out.
     */
    #[Optional]
    public ?bool $hideMedia;

    /**
     * Set `true` to leave the tweet this one replies to out.
     */
    #[Optional]
    public ?bool $hideThread;

    /**
     * Set `true` to leave the widget script tag out, for pages that load it once themselves.
     */
    #[Optional]
    public ?bool $omitScript;

    /**
     * Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     */
    #[Optional]
    public ?string $fields;

    /**
     * Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     */
    #[Optional]
    public ?string $omit;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Theme|value-of<Theme>|null $theme
     */
    public static function with(Theme|string|null $theme = null, ?bool $hideMedia = null, ?bool $hideThread = null, ?bool $omitScript = null, ?string $fields = null, ?string $omit = null): self
    {
        $self = new self;

        null !== $theme && $self['theme'] = $theme;
        null !== $hideMedia && $self['hideMedia'] = $hideMedia;
        null !== $hideThread && $self['hideThread'] = $hideThread;
        null !== $omitScript && $self['omitScript'] = $omitScript;
        null !== $fields && $self['fields'] = $fields;
        null !== $omit && $self['omit'] = $omit;

        return $self;
    }

    /**
     * Color theme of the embed. X uses light when left out.
     *
     * @param Theme|value-of<Theme>|null $theme
     */
    public function withTheme(Theme|string|null $theme): self
    {
        $self = clone $this;
        $self['theme'] = $theme;

        return $self;
    }

    /**
     * Set `true` to leave photos, videos, and link cards out.
     */
    public function withHideMedia(?bool $hideMedia): self
    {
        $self = clone $this;
        $self['hideMedia'] = $hideMedia;

        return $self;
    }

    /**
     * Set `true` to leave the tweet this one replies to out.
     */
    public function withHideThread(?bool $hideThread): self
    {
        $self = clone $this;
        $self['hideThread'] = $hideThread;

        return $self;
    }

    /**
     * Set `true` to leave the widget script tag out, for pages that load it once themselves.
     */
    public function withOmitScript(?bool $omitScript): self
    {
        $self = clone $this;
        $self['omitScript'] = $omitScript;

        return $self;
    }

    /**
     * Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     */
    public function withFields(?string $fields): self
    {
        $self = clone $this;
        $self['fields'] = $fields;

        return $self;
    }

    /**
     * Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     */
    public function withOmit(?string $omit): self
    {
        $self = clone $this;
        $self['omit'] = $omit;

        return $self;
    }
}
