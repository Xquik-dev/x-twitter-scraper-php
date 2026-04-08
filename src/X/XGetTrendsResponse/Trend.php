<?php

declare(strict_types=1);

namespace XTwitterScraper\X\XGetTrendsResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TrendShape = array{
 *   name: string, description?: string|null, query?: string|null, rank?: int|null
 * }
 */
final class Trend implements BaseModel
{
    /** @use SdkModel<TrendShape> */
    use SdkModel;

    #[Required]
    public string $name;

    #[Optional]
    public ?string $description;

    #[Optional]
    public ?string $query;

    #[Optional]
    public ?int $rank;

    /**
     * `new Trend()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Trend::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Trend)->withName(...)
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
        string $name,
        ?string $description = null,
        ?string $query = null,
        ?int $rank = null,
    ): self {
        $self = new self;

        $self['name'] = $name;

        null !== $description && $self['description'] = $description;
        null !== $query && $self['query'] = $query;
        null !== $rank && $self['rank'] = $rank;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withQuery(string $query): self
    {
        $self = clone $this;
        $self['query'] = $query;

        return $self;
    }

    public function withRank(int $rank): self
    {
        $self = clone $this;
        $self['rank'] = $rank;

        return $self;
    }
}
