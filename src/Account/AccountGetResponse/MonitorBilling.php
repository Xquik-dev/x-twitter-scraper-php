<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Account\AccountGetResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type MonitorBillingShape = array{
 *   activeDailyEstimate: string,
 *   activeHourlyBurn: string,
 *   creditsPerActiveMonitorDay: string,
 *   creditsPerActiveMonitorHour: string,
 *   eventsIncluded: bool,
 *   instantCheckIntervalSeconds: int,
 *   unlimitedSlots: bool,
 * }
 */
final class MonitorBilling implements BaseModel
{
    /** @use SdkModel<MonitorBillingShape> */
    use SdkModel;

    /**
     * Estimated daily credits for currently active monitors.
     */
    #[Required]
    public string $activeDailyEstimate;

    /**
     * Credits charged each hour for currently active monitors.
     */
    #[Required]
    public string $activeHourlyBurn;

    /**
     * Rounded daily estimate for 1 active monitor.
     */
    #[Required]
    public string $creditsPerActiveMonitorDay;

    /**
     * Hourly credits charged for 1 active monitor.
     */
    #[Required]
    public string $creditsPerActiveMonitorHour;

    /**
     * Webhook and event deliveries are included in monitor billing.
     */
    #[Required]
    public bool $eventsIncluded;

    /**
     * Active monitors check every 1 second.
     */
    #[Required]
    public int $instantCheckIntervalSeconds;

    /**
     * Monitor slot count is unlimited.
     */
    #[Required]
    public bool $unlimitedSlots;

    /**
     * `new MonitorBilling()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MonitorBilling::with(
     *   activeDailyEstimate: ...,
     *   activeHourlyBurn: ...,
     *   creditsPerActiveMonitorDay: ...,
     *   creditsPerActiveMonitorHour: ...,
     *   eventsIncluded: ...,
     *   instantCheckIntervalSeconds: ...,
     *   unlimitedSlots: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MonitorBilling)
     *   ->withActiveDailyEstimate(...)
     *   ->withActiveHourlyBurn(...)
     *   ->withCreditsPerActiveMonitorDay(...)
     *   ->withCreditsPerActiveMonitorHour(...)
     *   ->withEventsIncluded(...)
     *   ->withInstantCheckIntervalSeconds(...)
     *   ->withUnlimitedSlots(...)
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
    public static function with(
        string $activeDailyEstimate,
        string $activeHourlyBurn,
        string $creditsPerActiveMonitorDay,
        string $creditsPerActiveMonitorHour,
        bool $eventsIncluded,
        int $instantCheckIntervalSeconds,
        bool $unlimitedSlots,
    ): self {
        $self = new self;

        $self['activeDailyEstimate'] = $activeDailyEstimate;
        $self['activeHourlyBurn'] = $activeHourlyBurn;
        $self['creditsPerActiveMonitorDay'] = $creditsPerActiveMonitorDay;
        $self['creditsPerActiveMonitorHour'] = $creditsPerActiveMonitorHour;
        $self['eventsIncluded'] = $eventsIncluded;
        $self['instantCheckIntervalSeconds'] = $instantCheckIntervalSeconds;
        $self['unlimitedSlots'] = $unlimitedSlots;

        return $self;
    }

    /**
     * Estimated daily credits for currently active monitors.
     */
    public function withActiveDailyEstimate(string $activeDailyEstimate): self
    {
        $self = clone $this;
        $self['activeDailyEstimate'] = $activeDailyEstimate;

        return $self;
    }

    /**
     * Credits charged each hour for currently active monitors.
     */
    public function withActiveHourlyBurn(string $activeHourlyBurn): self
    {
        $self = clone $this;
        $self['activeHourlyBurn'] = $activeHourlyBurn;

        return $self;
    }

    /**
     * Rounded daily estimate for 1 active monitor.
     */
    public function withCreditsPerActiveMonitorDay(
        string $creditsPerActiveMonitorDay
    ): self {
        $self = clone $this;
        $self['creditsPerActiveMonitorDay'] = $creditsPerActiveMonitorDay;

        return $self;
    }

    /**
     * Hourly credits charged for 1 active monitor.
     */
    public function withCreditsPerActiveMonitorHour(
        string $creditsPerActiveMonitorHour
    ): self {
        $self = clone $this;
        $self['creditsPerActiveMonitorHour'] = $creditsPerActiveMonitorHour;

        return $self;
    }

    /**
     * Webhook and event deliveries are included in monitor billing.
     */
    public function withEventsIncluded(bool $eventsIncluded): self
    {
        $self = clone $this;
        $self['eventsIncluded'] = $eventsIncluded;

        return $self;
    }

    /**
     * Active monitors check every 1 second.
     */
    public function withInstantCheckIntervalSeconds(
        int $instantCheckIntervalSeconds
    ): self {
        $self = clone $this;
        $self['instantCheckIntervalSeconds'] = $instantCheckIntervalSeconds;

        return $self;
    }

    /**
     * Monitor slot count is unlimited.
     */
    public function withUnlimitedSlots(bool $unlimitedSlots): self
    {
        $self = clone $this;
        $self['unlimitedSlots'] = $unlimitedSlots;

        return $self;
    }
}
