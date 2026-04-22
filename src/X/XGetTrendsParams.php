<?php

declare(strict_types=1);

namespace XTwitterScraper\X;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get trending hashtags & topics from X by region.
 *
 * @see XTwitterScraper\Services\XService::getTrends()
 *
 * @phpstan-type XGetTrendsParamsShape = array{count?: int|null, woeid?: int|null}
 */
final class XGetTrendsParams implements BaseModel
{
    /** @use SdkModel<XGetTrendsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Number of trending topics to return (1-50, default 30).
     */
    #[Optional]
    public ?int $count;

    /**
     * Region WOEID (1=Worldwide, 23424977=US, 23424975=UK, 23424969=Turkey).
     */
    #[Optional]
    public ?int $woeid;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $count = null, ?int $woeid = null): self
    {
        $self = new self;

        null !== $count && $self['count'] = $count;
        null !== $woeid && $self['woeid'] = $woeid;

        return $self;
    }

    /**
     * Number of trending topics to return (1-50, default 30).
     */
    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    /**
     * Region WOEID (1=Worldwide, 23424977=US, 23424975=UK, 23424969=Turkey).
     */
    public function withWoeid(int $woeid): self
    {
        $self = clone $this;
        $self['woeid'] = $woeid;

        return $self;
    }
}
