<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Account\AccountGetResponse;

use XTwitterScraper\Account\AccountGetResponse\Subscription\Status;
use XTwitterScraper\Account\AccountGetResponse\Subscription\Tier;
use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type SubscriptionShape = array{
 *   status: Status|value-of<Status>,
 *   tier?: Tier|value-of<Tier>|null,
 *   currentPeriodStart?: \DateTimeInterface|null,
 *   currentPeriodEnd?: \DateTimeInterface|null,
 * }
 */
final class Subscription implements BaseModel
{
    /** @use SdkModel<SubscriptionShape> */
    use SdkModel;

    /**
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * @var value-of<Tier>|null $tier
     */
    #[Optional(enum: Tier::class)]
    public ?string $tier;

    #[Optional]
    public ?\DateTimeInterface $currentPeriodStart;

    /**
     * Renewal date, or the end date when canceling.
     */
    #[Optional]
    public ?\DateTimeInterface $currentPeriodEnd;

    /**
     * `new Subscription()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Subscription::with(status: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Subscription)->withStatus(...)
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
     * @param Status|value-of<Status> $status
     * @param Tier|value-of<Tier>|null $tier
     */
    public static function with(Status|string $status, Tier|string|null $tier = null, ?\DateTimeInterface $currentPeriodStart = null, ?\DateTimeInterface $currentPeriodEnd = null): self
    {
        $self = new self;

        $self['status'] = $status;

        null !== $tier && $self['tier'] = $tier;
        null !== $currentPeriodStart && $self['currentPeriodStart'] = $currentPeriodStart;
        null !== $currentPeriodEnd && $self['currentPeriodEnd'] = $currentPeriodEnd;

        return $self;
    }

    /**
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * @param Tier|value-of<Tier>|null $tier
     */
    public function withTier(Tier|string|null $tier): self
    {
        $self = clone $this;
        $self['tier'] = $tier;

        return $self;
    }

    public function withCurrentPeriodStart(?\DateTimeInterface $currentPeriodStart): self
    {
        $self = clone $this;
        $self['currentPeriodStart'] = $currentPeriodStart;

        return $self;
    }

    /**
     * Renewal date, or the end date when canceling.
     */
    public function withCurrentPeriodEnd(?\DateTimeInterface $currentPeriodEnd): self
    {
        $self = clone $this;
        $self['currentPeriodEnd'] = $currentPeriodEnd;

        return $self;
    }
}
