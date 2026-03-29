<?php

declare(strict_types=1);

namespace XTwitterScraper\Account;

use XTwitterScraper\Account\AccountGetResponse\CurrentPeriod;
use XTwitterScraper\Account\AccountGetResponse\Plan;
use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type CurrentPeriodShape from \XTwitterScraper\Account\AccountGetResponse\CurrentPeriod
 *
 * @phpstan-type AccountGetResponseShape = array{
 *   monitorsAllowed: int,
 *   monitorsUsed: int,
 *   plan: Plan|value-of<Plan>,
 *   currentPeriod?: null|CurrentPeriod|CurrentPeriodShape,
 * }
 */
final class AccountGetResponse implements BaseModel
{
    /** @use SdkModel<AccountGetResponseShape> */
    use SdkModel;

    #[Required]
    public int $monitorsAllowed;

    #[Required]
    public int $monitorsUsed;

    /** @var value-of<Plan> $plan */
    #[Required(enum: Plan::class)]
    public string $plan;

    #[Optional]
    public ?CurrentPeriod $currentPeriod;

    /**
     * `new AccountGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AccountGetResponse::with(monitorsAllowed: ..., monitorsUsed: ..., plan: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AccountGetResponse)
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
     * @param Plan|value-of<Plan> $plan
     * @param CurrentPeriod|CurrentPeriodShape|null $currentPeriod
     */
    public static function with(
        int $monitorsAllowed,
        int $monitorsUsed,
        Plan|string $plan,
        CurrentPeriod|array|null $currentPeriod = null,
    ): self {
        $self = new self;

        $self['monitorsAllowed'] = $monitorsAllowed;
        $self['monitorsUsed'] = $monitorsUsed;
        $self['plan'] = $plan;

        null !== $currentPeriod && $self['currentPeriod'] = $currentPeriod;

        return $self;
    }

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
     * @param CurrentPeriod|CurrentPeriodShape $currentPeriod
     */
    public function withCurrentPeriod(CurrentPeriod|array $currentPeriod): self
    {
        $self = clone $this;
        $self['currentPeriod'] = $currentPeriod;

        return $self;
    }
}
