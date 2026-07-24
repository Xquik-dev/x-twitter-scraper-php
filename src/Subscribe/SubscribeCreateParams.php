<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Subscribe;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Subscribe\SubscribeCreateParams\Tier;

/**
 * Create a subscription checkout or billing-management URL only after the user confirms. The request never completes payment by itself.
 *
 * @see XTwitterScraper\Services\SubscribeService::create()
 *
 * @phpstan-type SubscribeCreateParamsShape = array{
 *   tier?: null|Tier|value-of<Tier>
 * }
 */
final class SubscribeCreateParams implements BaseModel
{
    /** @use SdkModel<SubscribeCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Subscription tier to pre-select.
     *
     * @var value-of<Tier>|null $tier
     */
    #[Optional(enum: Tier::class)]
    public ?string $tier;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Tier|value-of<Tier>|null $tier
     */
    public static function with(Tier|string|null $tier = null): self
    {
        $self = new self;

        null !== $tier && $self['tier'] = $tier;

        return $self;
    }

    /**
     * Subscription tier to pre-select.
     *
     * @param Tier|value-of<Tier> $tier
     */
    public function withTier(Tier|string $tier): self
    {
        $self = clone $this;
        $self['tier'] = $tier;

        return $self;
    }
}
