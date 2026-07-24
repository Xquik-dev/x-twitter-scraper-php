<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Monitors\Keywords;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Monitors\Keywords\KeywordListResponse\Monitor;

/**
 * @phpstan-import-type MonitorShape from \XTwitterScraper\Monitors\Keywords\KeywordListResponse\Monitor
 *
 * @phpstan-type KeywordListResponseShape = array{
 *   monitors: list<Monitor|MonitorShape>, total: int
 * }
 */
final class KeywordListResponse implements BaseModel
{
    /** @use SdkModel<KeywordListResponseShape> */
    use SdkModel;

    /** @var list<Monitor> $monitors */
    #[Required(list: Monitor::class)]
    public array $monitors;

    #[Required]
    public int $total;

    /**
     * `new KeywordListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * KeywordListResponse::with(monitors: ..., total: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new KeywordListResponse)->withMonitors(...)->withTotal(...)
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
     * @param list<Monitor|MonitorShape> $monitors
     */
    public static function with(array $monitors, int $total): self
    {
        $self = new self;

        $self['monitors'] = $monitors;
        $self['total'] = $total;

        return $self;
    }

    /**
     * @param list<Monitor|MonitorShape> $monitors
     */
    public function withMonitors(array $monitors): self
    {
        $self = clone $this;
        $self['monitors'] = $monitors;

        return $self;
    }

    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }
}
