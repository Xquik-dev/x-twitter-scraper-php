<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\Retweet\RetweetDeleteResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Tweets\Retweet\RetweetDeleteResponse\Billing\Status;

/**
 * plannedCredits is the approved maximum. chargedCredits comes from the settled credit ledger. Pending or failed writes are not charged.
 *
 * @phpstan-type BillingShape = array{
 *   charged: bool,
 *   chargedCredits: string,
 *   plannedCredits: string,
 *   status: \XTwitterScraper\X\Tweets\Retweet\RetweetDeleteResponse\Billing\Status|value-of<\XTwitterScraper\X\Tweets\Retweet\RetweetDeleteResponse\Billing\Status>,
 * }
 */
final class Billing implements BaseModel
{
    /** @use SdkModel<BillingShape> */
    use SdkModel;

    #[Required]
    public bool $charged;

    #[Required]
    public string $chargedCredits;

    #[Required]
    public string $plannedCredits;

    /**
     * @var value-of<Status> $status
     */
    #[Required(
        enum: Status::class,
    )]
    public string $status;

    /**
     * `new Billing()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Billing::with(
     *   charged: ..., chargedCredits: ..., plannedCredits: ..., status: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Billing)
     *   ->withCharged(...)
     *   ->withChargedCredits(...)
     *   ->withPlannedCredits(...)
     *   ->withStatus(...)
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
     */
    public static function with(
        bool $charged,
        string $chargedCredits,
        string $plannedCredits,
        Status|string $status,
    ): self {
        $self = new self;

        $self['charged'] = $charged;
        $self['chargedCredits'] = $chargedCredits;
        $self['plannedCredits'] = $plannedCredits;
        $self['status'] = $status;

        return $self;
    }

    public function withCharged(bool $charged): self
    {
        $self = clone $this;
        $self['charged'] = $charged;

        return $self;
    }

    public function withChargedCredits(string $chargedCredits): self
    {
        $self = clone $this;
        $self['chargedCredits'] = $chargedCredits;

        return $self;
    }

    public function withPlannedCredits(string $plannedCredits): self
    {
        $self = clone $this;
        $self['plannedCredits'] = $plannedCredits;

        return $self;
    }

    /**
     * @param Status|value-of<Status> $status
     */
    public function withStatus(
        Status|string $status,
    ): self {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
