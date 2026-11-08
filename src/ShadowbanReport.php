<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\ShadowbanReport\Account;
use XTwitterScraper\ShadowbanReport\Checks;
use XTwitterScraper\ShadowbanReport\Overall;

/**
 * @phpstan-type ShadowbanReportShape = array{
 *   username: string|null,
 *   userID: string|null,
 *   account: Account|value-of<Account>,
 *   checkedAt: \DateTimeInterface,
 *   overall: Overall|value-of<Overall>,
 *   checks: Checks|array<string,mixed>,
 * }
 */
final class ShadowbanReport implements BaseModel
{
    /** @use SdkModel<ShadowbanReportShape> */
    use SdkModel;

    /**
     * Username of the account. Null for a suspended account asked for by ID.
     */
    #[Required]
    public ?string $username;

    /**
     * ID of the account. Null for a suspended account asked for by username.
     */
    #[Required('userId')]
    public ?string $userID;

    /**
     * Whether the account is active, protected or suspended.
     *
     * @var value-of<Account> $account
     */
    #[Required(enum: Account::class)]
    public string $account;

    /**
     * When the check ran.
     */
    #[Required]
    public \DateTimeInterface $checkedAt;

    /**
     * `suspended` means X suspended the account. `limited` means at least 1 check failed. `clear` means search & suggestions passed with no fail. `unclear` means neither of those.
     *
     * @var value-of<Overall> $overall
     */
    #[Required(enum: Overall::class)]
    public string $overall;

    /**
     * The 9 checks, each with a verdict, a reason & evidence.
     */
    #[Required]
    public Checks $checks;

    /**
     * `new ShadowbanReport()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ShadowbanReport::with(username: ..., userID: ..., account: ..., checkedAt: ..., overall: ..., checks: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ShadowbanReport)->withUsername(...)->withUserID(...)->withAccount(...)->withCheckedAt(...)->withOverall(...)->withChecks(...)
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
     * @param Account|value-of<Account> $account
     * @param Overall|value-of<Overall> $overall
     * @param Checks|array<string,mixed> $checks
     */
    public static function with(?string $username, ?string $userID, Account|string $account, \DateTimeInterface $checkedAt, Overall|string $overall, Checks|array $checks): self
    {
        $self = new self;

        $self['username'] = $username;
        $self['userID'] = $userID;
        $self['account'] = $account;
        $self['checkedAt'] = $checkedAt;
        $self['overall'] = $overall;
        $self['checks'] = $checks;

        return $self;
    }

    /**
     * Username of the account. Null for a suspended account asked for by ID.
     */
    public function withUsername(?string $username): self
    {
        $self = clone $this;
        $self['username'] = $username;

        return $self;
    }

    /**
     * ID of the account. Null for a suspended account asked for by username.
     */
    public function withUserID(?string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }

    /**
     * Whether the account is active, protected or suspended.
     *
     * @param Account|value-of<Account> $account
     */
    public function withAccount(Account|string $account): self
    {
        $self = clone $this;
        $self['account'] = $account;

        return $self;
    }

    /**
     * When the check ran.
     */
    public function withCheckedAt(\DateTimeInterface $checkedAt): self
    {
        $self = clone $this;
        $self['checkedAt'] = $checkedAt;

        return $self;
    }

    /**
     * `suspended` means X suspended the account. `limited` means at least 1 check failed. `clear` means search & suggestions passed with no fail. `unclear` means neither of those.
     *
     * @param Overall|value-of<Overall> $overall
     */
    public function withOverall(Overall|string $overall): self
    {
        $self = clone $this;
        $self['overall'] = $overall;

        return $self;
    }

    /**
     * The 9 checks, each with a verdict, a reason & evidence.
     *
     * @param Checks|array<string,mixed> $checks
     */
    public function withChecks(Checks|array $checks): self
    {
        $self = clone $this;
        $self['checks'] = $checks;

        return $self;
    }
}
