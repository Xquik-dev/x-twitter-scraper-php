<?php

declare(strict_types=1);

namespace XTwitterScraper\Trends;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get trending topics.
 *
 * @see XTwitterScraper\Services\TrendsService::list()
 *
 * @phpstan-type TrendListParamsShape = array{count?: int|null, woeid?: int|null}
 */
final class TrendListParams implements BaseModel
{
    /** @use SdkModel<TrendListParamsShape> */
    use SdkModel;
    use SdkParams;

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
