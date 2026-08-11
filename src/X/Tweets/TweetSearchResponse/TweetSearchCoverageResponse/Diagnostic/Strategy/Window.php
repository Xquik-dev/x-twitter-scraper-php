<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetSearchResponse\TweetSearchCoverageResponse\Diagnostic\Strategy;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Non-overlapping time partition used by one strategy.
 *
 * @phpstan-type WindowShape = array{
 *   sinceTime: \DateTimeInterface, untilTime: \DateTimeInterface
 * }
 */
final class Window implements BaseModel
{
    /** @use SdkModel<WindowShape> */
    use SdkModel;

    #[Required]
    public \DateTimeInterface $sinceTime;

    #[Required]
    public \DateTimeInterface $untilTime;

    /**
     * `new Window()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Window::with(sinceTime: ..., untilTime: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Window)->withSinceTime(...)->withUntilTime(...)
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
        \DateTimeInterface $sinceTime,
        \DateTimeInterface $untilTime
    ): self {
        $self = new self;

        $self['sinceTime'] = $sinceTime;
        $self['untilTime'] = $untilTime;

        return $self;
    }

    public function withSinceTime(\DateTimeInterface $sinceTime): self
    {
        $self = clone $this;
        $self['sinceTime'] = $sinceTime;

        return $self;
    }

    public function withUntilTime(\DateTimeInterface $untilTime): self
    {
        $self = clone $this;
        $self['untilTime'] = $untilTime;

        return $self;
    }
}
