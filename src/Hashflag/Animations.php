<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Hashflag;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type AnimationsShape = array{
 *   context: string|null,
 *   assetUrl: string,
 *   priority: float|null,
 * }
 */
final class Animations implements BaseModel
{
    /** @use SdkModel<AnimationsShape> */
    use SdkModel;

    /**
     * What plays the animation, such as Like.
     */
    #[Required]
    public ?string $context;

    /**
     * Animation file.
     */
    #[Required]
    public string $assetUrl;

    /**
     * X's order among the animations of a hashtag.
     */
    #[Required]
    public ?float $priority;

    /**
     * `new Animations()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Animations::with(context: ..., assetUrl: ..., priority: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Animations)->withContext(...)->withAssetUrl(...)->withPriority(...)
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
    public static function with(?string $context, string $assetUrl, ?float $priority): self
    {
        $self = new self;

        $self['context'] = $context;
        $self['assetUrl'] = $assetUrl;
        $self['priority'] = $priority;

        return $self;
    }

    /**
     * What plays the animation, such as Like.
     */
    public function withContext(?string $context): self
    {
        $self = clone $this;
        $self['context'] = $context;

        return $self;
    }

    /**
     * Animation file.
     */
    public function withAssetUrl(string $assetUrl): self
    {
        $self = clone $this;
        $self['assetUrl'] = $assetUrl;

        return $self;
    }

    /**
     * X's order among the animations of a hashtag.
     */
    public function withPriority(?float $priority): self
    {
        $self = clone $this;
        $self['priority'] = $priority;

        return $self;
    }
}
