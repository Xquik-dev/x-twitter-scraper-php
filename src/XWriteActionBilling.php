<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\XWriteActionBilling\Status;

/**
 * @phpstan-type XWriteActionBillingShape = array{
 *   status: Status|value-of<Status>,
 *   charged: bool,
 *   plannedCredits: string,
 *   chargedCredits: string,
 * }
 */
final class XWriteActionBilling implements BaseModel
{
    /** @use SdkModel<XWriteActionBillingShape> */
    use SdkModel;

    /**
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    #[Required]
    public bool $charged;

    #[Required]
    public string $plannedCredits;

    #[Required]
    public string $chargedCredits;

    /**
     * `new XWriteActionBilling()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XWriteActionBilling::with(status: ..., charged: ..., plannedCredits: ..., chargedCredits: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XWriteActionBilling)->withStatus(...)->withCharged(...)->withPlannedCredits(...)->withChargedCredits(...)
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
    public static function with(Status|string $status, bool $charged, string $plannedCredits, string $chargedCredits): self
    {
        $self = new self;

        $self['status'] = $status;
        $self['charged'] = $charged;
        $self['plannedCredits'] = $plannedCredits;
        $self['chargedCredits'] = $chargedCredits;

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

    public function withCharged(bool $charged): self
    {
        $self = clone $this;
        $self['charged'] = $charged;

        return $self;
    }

    public function withPlannedCredits(string $plannedCredits): self
    {
        $self = clone $this;
        $self['plannedCredits'] = $plannedCredits;

        return $self;
    }

    public function withChargedCredits(string $chargedCredits): self
    {
        $self = clone $this;
        $self['chargedCredits'] = $chargedCredits;

        return $self;
    }
}
