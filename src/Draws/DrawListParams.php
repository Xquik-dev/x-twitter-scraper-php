<?php

declare(strict_types=1);

namespace XTwitterScraper\Draws;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * List draws.
 *
 * @see XTwitterScraper\Services\DrawsService::list()
 *
 * @phpstan-type DrawListParamsShape = array{after?: string|null, limit?: int|null}
 */
final class DrawListParams implements BaseModel
{
    /** @use SdkModel<DrawListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Cursor for keyset pagination.
     */
    #[Optional]
    public ?string $after;

    /**
     * Maximum number of items to return (1-100, default 50).
     */
    #[Optional]
    public ?int $limit;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $after = null, ?int $limit = null): self
    {
        $self = new self;

        null !== $after && $self['after'] = $after;
        null !== $limit && $self['limit'] = $limit;

        return $self;
    }

    /**
     * Cursor for keyset pagination.
     */
    public function withAfter(string $after): self
    {
        $self = clone $this;
        $self['after'] = $after;

        return $self;
    }

    /**
     * Maximum number of items to return (1-100, default 50).
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }
}
