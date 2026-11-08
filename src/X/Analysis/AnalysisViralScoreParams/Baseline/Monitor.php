<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Analysis\AnalysisViralScoreParams\Baseline;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type MonitorShape = array{
 *   configurationFingerprint?: string|null,
 * }
 */
final class Monitor implements BaseModel
{
    /** @use SdkModel<MonitorShape> */
    use SdkModel;

    #[Optional]
    public ?string $configurationFingerprint;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $configurationFingerprint = null): self
    {
        $self = new self;

        null !== $configurationFingerprint && $self['configurationFingerprint'] = $configurationFingerprint;

        return $self;
    }

    public function withConfigurationFingerprint(?string $configurationFingerprint): self
    {
        $self = clone $this;
        $self['configurationFingerprint'] = $configurationFingerprint;

        return $self;
    }
}
