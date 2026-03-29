<?php

declare(strict_types=1);

namespace XTwitterScraper\Monitors;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Monitors\MonitorListResponse\Monitor;

/**
 * @phpstan-import-type MonitorShape from \XTwitterScraper\Monitors\MonitorListResponse\Monitor
 *
 * @phpstan-type MonitorListResponseShape = array{
 *   monitors: list<Monitor|MonitorShape>, total: int
 * }
 */
final class MonitorListResponse implements BaseModel
{
    /** @use SdkModel<MonitorListResponseShape> */
    use SdkModel;

    /** @var list<Monitor> $monitors */
    #[Required(list: Monitor::class)]
    public array $monitors;

    #[Required]
    public int $total;

    /**
     * `new MonitorListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MonitorListResponse::with(monitors: ..., total: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MonitorListResponse)->withMonitors(...)->withTotal(...)
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
