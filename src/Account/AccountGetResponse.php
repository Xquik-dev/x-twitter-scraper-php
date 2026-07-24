<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Account;

use XTwitterScraper\Account\AccountGetResponse\CreditInfo;
use XTwitterScraper\Account\AccountGetResponse\MonitorBilling;
use XTwitterScraper\Account\AccountGetResponse\Plan;
use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type MonitorBillingShape from \XTwitterScraper\Account\AccountGetResponse\MonitorBilling
 * @phpstan-import-type CreditInfoShape from \XTwitterScraper\Account\AccountGetResponse\CreditInfo
 *
 * @phpstan-type AccountGetResponseShape = array{
 *   monitorBilling: MonitorBilling|MonitorBillingShape,
 *   monitorsAllowed: int,
 *   monitorsUsed: int,
 *   plan: Plan|value-of<Plan>,
 *   creditInfo?: null|CreditInfo|CreditInfoShape,
 *   xUsername?: string|null,
 * }
 */
final class AccountGetResponse implements BaseModel
{
    /** @use SdkModel<AccountGetResponseShape> */
    use SdkModel;

    #[Required]
    public MonitorBilling $monitorBilling;

    /**
     * @deprecated Monitor slots are unlimited. Use monitorBilling.unlimitedSlots instead.
     *
     * Deprecated. Monitor slots are unlimited, so this is always Number.MAX_SAFE_INTEGER.
     */
    #[Required]
    public int $monitorsAllowed;

    #[Required]
    public int $monitorsUsed;

    /** @var value-of<Plan> $plan */
    #[Required(enum: Plan::class)]
    public string $plan;

    #[Optional]
    public ?CreditInfo $creditInfo;

    /**
     * Linked X username, omitted when no X account is connected.
     */
    #[Optional]
    public ?string $xUsername;

    /**
     * `new AccountGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AccountGetResponse::with(
     *   monitorBilling: ..., monitorsAllowed: ..., monitorsUsed: ..., plan: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AccountGetResponse)
     *   ->withMonitorBilling(...)
     *   ->withMonitorsAllowed(...)
     *   ->withMonitorsUsed(...)
     *   ->withPlan(...)
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
     * @param MonitorBilling|MonitorBillingShape $monitorBilling
     * @param Plan|value-of<Plan> $plan
     * @param CreditInfo|CreditInfoShape|null $creditInfo
     */
    public static function with(
        MonitorBilling|array $monitorBilling,
        int $monitorsAllowed,
        int $monitorsUsed,
        Plan|string $plan,
        CreditInfo|array|null $creditInfo = null,
        ?string $xUsername = null,
    ): self {
        $self = new self;

        $self['monitorBilling'] = $monitorBilling;
        $self['monitorsAllowed'] = $monitorsAllowed;
        $self['monitorsUsed'] = $monitorsUsed;
        $self['plan'] = $plan;

        null !== $creditInfo && $self['creditInfo'] = $creditInfo;
        null !== $xUsername && $self['xUsername'] = $xUsername;

        return $self;
    }

    /**
     * @param MonitorBilling|MonitorBillingShape $monitorBilling
     */
    public function withMonitorBilling(
        MonitorBilling|array $monitorBilling
    ): self {
        $self = clone $this;
        $self['monitorBilling'] = $monitorBilling;

        return $self;
    }

    /**
     * Deprecated. Monitor slots are unlimited, so this is always Number.MAX_SAFE_INTEGER.
     */
    public function withMonitorsAllowed(int $monitorsAllowed): self
    {
        $self = clone $this;
        $self['monitorsAllowed'] = $monitorsAllowed;

        return $self;
    }

    public function withMonitorsUsed(int $monitorsUsed): self
    {
        $self = clone $this;
        $self['monitorsUsed'] = $monitorsUsed;

        return $self;
    }

    /**
     * @param Plan|value-of<Plan> $plan
     */
    public function withPlan(Plan|string $plan): self
    {
        $self = clone $this;
        $self['plan'] = $plan;

        return $self;
    }

    /**
     * @param CreditInfo|CreditInfoShape $creditInfo
     */
    public function withCreditInfo(CreditInfo|array $creditInfo): self
    {
        $self = clone $this;
        $self['creditInfo'] = $creditInfo;

        return $self;
    }

    /**
     * Linked X username, omitted when no X account is connected.
     */
    public function withXUsername(string $xUsername): self
    {
        $self = clone $this;
        $self['xUsername'] = $xUsername;

        return $self;
    }
}
