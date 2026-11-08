<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type UserTipJarShape = array{
 *   bandcampHandle?: string|null,
 *   bitcoinHandle?: string|null,
 *   cashAppHandle?: string|null,
 *   ethereumHandle?: string|null,
 *   gofundmeHandle?: string|null,
 *   isEnabled?: bool|null,
 *   patreonHandle?: string|null,
 *   payPalHandle?: string|null,
 *   venmoHandle?: string|null,
 * }
 */
final class UserTipJar implements BaseModel
{
    /** @use SdkModel<UserTipJarShape> */
    use SdkModel;

    #[Optional]
    public ?string $bandcampHandle;

    #[Optional]
    public ?string $bitcoinHandle;

    #[Optional]
    public ?string $cashAppHandle;

    #[Optional]
    public ?string $ethereumHandle;

    #[Optional]
    public ?string $gofundmeHandle;

    #[Optional]
    public ?bool $isEnabled;

    #[Optional]
    public ?string $patreonHandle;

    #[Optional]
    public ?string $payPalHandle;

    #[Optional]
    public ?string $venmoHandle;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $bandcampHandle = null, ?string $bitcoinHandle = null, ?string $cashAppHandle = null, ?string $ethereumHandle = null, ?string $gofundmeHandle = null, ?bool $isEnabled = null, ?string $patreonHandle = null, ?string $payPalHandle = null, ?string $venmoHandle = null): self
    {
        $self = new self;

        null !== $bandcampHandle && $self['bandcampHandle'] = $bandcampHandle;
        null !== $bitcoinHandle && $self['bitcoinHandle'] = $bitcoinHandle;
        null !== $cashAppHandle && $self['cashAppHandle'] = $cashAppHandle;
        null !== $ethereumHandle && $self['ethereumHandle'] = $ethereumHandle;
        null !== $gofundmeHandle && $self['gofundmeHandle'] = $gofundmeHandle;
        null !== $isEnabled && $self['isEnabled'] = $isEnabled;
        null !== $patreonHandle && $self['patreonHandle'] = $patreonHandle;
        null !== $payPalHandle && $self['payPalHandle'] = $payPalHandle;
        null !== $venmoHandle && $self['venmoHandle'] = $venmoHandle;

        return $self;
    }

    public function withBandcampHandle(?string $bandcampHandle): self
    {
        $self = clone $this;
        $self['bandcampHandle'] = $bandcampHandle;

        return $self;
    }

    public function withBitcoinHandle(?string $bitcoinHandle): self
    {
        $self = clone $this;
        $self['bitcoinHandle'] = $bitcoinHandle;

        return $self;
    }

    public function withCashAppHandle(?string $cashAppHandle): self
    {
        $self = clone $this;
        $self['cashAppHandle'] = $cashAppHandle;

        return $self;
    }

    public function withEthereumHandle(?string $ethereumHandle): self
    {
        $self = clone $this;
        $self['ethereumHandle'] = $ethereumHandle;

        return $self;
    }

    public function withGofundmeHandle(?string $gofundmeHandle): self
    {
        $self = clone $this;
        $self['gofundmeHandle'] = $gofundmeHandle;

        return $self;
    }

    public function withIsEnabled(?bool $isEnabled): self
    {
        $self = clone $this;
        $self['isEnabled'] = $isEnabled;

        return $self;
    }

    public function withPatreonHandle(?string $patreonHandle): self
    {
        $self = clone $this;
        $self['patreonHandle'] = $patreonHandle;

        return $self;
    }

    public function withPayPalHandle(?string $payPalHandle): self
    {
        $self = clone $this;
        $self['payPalHandle'] = $payPalHandle;

        return $self;
    }

    public function withVenmoHandle(?string $venmoHandle): self
    {
        $self = clone $this;
        $self['venmoHandle'] = $venmoHandle;

        return $self;
    }
}
